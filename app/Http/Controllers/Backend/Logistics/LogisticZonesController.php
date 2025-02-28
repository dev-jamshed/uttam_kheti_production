<?php

namespace App\Http\Controllers\Backend\Logistics;

use App\Models\City;
use App\Models\Logistic;
use App\Models\LogisticZone;
use Illuminate\Http\Request;
use App\Models\LogisticZoneArea;
use App\Models\LogisticZoneCity;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class LogisticZonesController extends Controller
{

    # construct
    public function __construct()
    {
        $this->middleware(['permission:shipping_zones'])->only('index');
        $this->middleware(['permission:add_shipping_zones'])->only(['create', 'store']);
        $this->middleware(['permission:edit_shipping_zones'])->only(['edit', 'update']);
        $this->middleware(['permission:delete_shipping_zones'])->only(['delete']);
    }

    # zone list
    public function index(Request $request)
    {
        $searchKey = null;
        $searchLogistic = null;
        $logisticZones = LogisticZone::with('areas.area','cities.city')->latest();
        if ($request->search != null) {
            $logisticZones = $logisticZones->where('name', 'like', '%' . $request->search . '%');
            $searchKey = $request->search;
        }

        if ($request->searchLogistic) {
            $logisticZones->where('logistic_id', $request->searchLogistic);
            $searchLogistic = $request->searchLogistic;
        }
        $logisticZones = $logisticZones->paginate(paginationNumber());
        // return $logisticZones;
        return view('backend.pages.fulfillments.logisticZones.index', compact('logisticZones', 'searchKey', 'searchLogistic'));
    }

    # create zone
    public function create()
    {
        $logistics = Logistic::where('is_active', 1)->latest()->get();
        return view('backend.pages.fulfillments.logisticZones.create', compact('logistics'));
    }


    # create zone
    public function getLogisticCities(Request $request)
    {
        $logistic = Logistic::find($request->logistic_id);
        $html = '<option value="">' . localize("Select City") . '</option>';

        if (!is_null($logistic)) {
            $logisticCities = $logistic->cities()->pluck('city_id');
            $cities = City::isActive()->latest()->get();

            foreach ($cities as $city) {
                $html .= '<option value="' . $city->id . '">' . $city->name . '</option>';
            }
        }

        echo json_encode($html);
    }

    public function getCityAreas(Request $request)
    {
        // return $request;
        $cityId = is_array($request->city_ids) ? $request->city_ids[0] : $request->city_ids;
        $logisticId = $request->logistic_id;

        $city = City::find($cityId);
        $html = '<option value="">' . localize("Select Area") . '</option>';

        if ($city) {
            $logisticAreas = LogisticZoneArea::where('logistic_id', $logisticId)->pluck('area_id');
            Log::info($logisticAreas);
            $areas = $city->areas()->isActive()->whereNotIn('id', $logisticAreas)->get();

            foreach ($areas as $area) {
                $html .= '<option value="' . $area->id . '">' . $area->name . '</option>';
            }
        }

        echo json_encode($html);
    }



    # zone store
    public function store(Request $request)
    {
        $logisticZone = new LogisticZone;
        $logisticZone->name = $request->name;
        $logisticZone->logistic_id = $request->logistic_id;
        $logisticZone->standard_delivery_charge = $request->standard_delivery_charge;
        $logisticZone->standard_delivery_time = $request->standard_delivery_time;
        $logisticZone->save();

        foreach ($request->city_ids as $city_id) {
            // LogisticZoneCity::where('logistic_id', $logisticZone->logistic_id)
            //     ->where('city_id', $city_id)
            //     ->delete();
            $logisticZoneCity                   = new LogisticZoneCity;
            $logisticZoneCity->logistic_id      = $logisticZone->logistic_id;
            $logisticZoneCity->logistic_zone_id = $logisticZone->id;
            $logisticZoneCity->city_id          = $city_id;
            $logisticZoneCity->save();
            Log::info($logisticZoneCity);
            // return $logisticZoneCity;
        }

        foreach ($request->area_ids as $area_id) {
            // Delete existing records for the specific area
            LogisticZoneArea::where('logistic_id', $logisticZone->logistic_id)
                ->where('area_id', $area_id)
                ->delete();
            
            // Create a new entry for the logistic zone area
            $logisticZoneArea = new LogisticZoneArea;
            $logisticZoneArea->logistic_id      = $logisticZone->logistic_id;
            $logisticZoneArea->logistic_zone_id = $logisticZone->id;
            $logisticZoneArea->area_id          = $area_id;
            
            // Save the new record
            $logisticZoneArea->save();
        }

        
        
        flash(localize('Zone has been inserted successfully'))->success();
        return redirect()->route('admin.logisticZones.index');
    }

    # edit zone
    public function edit(Request $request, $id)
    {
        $logisticZone = LogisticZone::findOrFail($id);
        $cities       = City::isActive()->latest()->get();
        return view('backend.pages.fulfillments.logisticZones.edit', compact('logisticZone', 'cities'));
    }

    # update zone
    public function update(Request $request)
    {
        // return $request->area_ids;
        $logisticZone = LogisticZone::findOrFail($request->id);
        $logisticZone->name = $request->name;

        $logisticZone->standard_delivery_charge = $request->standard_delivery_charge;
        if ($request->express_delivery_charge) {
            $logisticZone->express_delivery_charge = $request->express_delivery_charge;
        }

        $logisticZone->standard_delivery_time = $request->standard_delivery_time;
        if ($request->express_delivery_charge) {
            $logisticZone->express_delivery_time = $request->express_delivery_time;
        }

        $logisticZone->save();

        // LogisticZoneCity::where('logistic_id', $logisticZone->logistic_id)
        //     ->delete();
        // foreach ($request->city_ids as $city_id) {
        //     $logisticZoneCity = new LogisticZoneCity;
        //     $logisticZoneCity->logistic_id = $logisticZone->logistic_id;
        //     $logisticZoneCity->logistic_zone_id = $logisticZone->id;
        //     $logisticZoneCity->city_id = $city_id;
        //     $logisticZoneCity->save();
        // }
        
        LogisticZoneArea::where('logistic_zone_id', $logisticZone->id)->delete();
        foreach ($request->area_ids as $area_id) {
            $logisticZoneArea = new LogisticZoneArea;
            $logisticZoneArea->logistic_id = $logisticZone->logistic_id;
            $logisticZoneArea->logistic_zone_id = $logisticZone->id;
            $logisticZoneArea->area_id = $area_id;
            $logisticZoneArea->save();
        }

        flash(localize('Zone has been updated successfully'))->success();
        return back();
    }

    # delete zone
    public function delete($id)
    {
        $logisticZone = LogisticZone::findOrFail($id);
        LogisticZoneCity::where('logistic_zone_id', $logisticZone->id)->delete();
        LogisticZoneArea::where('logistic_zone_id', $logisticZone->id)->delete();
        $logisticZone->delete();
        flash(localize('Zone has been deleted successfully'))->success();
        return back();
    }
}
