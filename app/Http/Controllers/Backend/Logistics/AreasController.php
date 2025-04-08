<?php

namespace App\Http\Controllers\Backend\Logistics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\City;

class AreasController extends Controller
{
    # construct
    public function __construct()
    {
        // $this->middleware(['permission:shipping_areas'])->only('index');
        // $this->middleware(['permission:add_shipping_areas'])->only('create');
        // $this->middleware(['permission:edit_shipping_areas'])->only('edit');
    }

    # area list
    public function index(Request $request)
    {

        $searchKey = null;
        
        $searchCity = null;
        $areas = Area::query();

        if ($request->search != null) {
            $areas = $areas->where('name', 'like', '%' . $request->search . '%');
            $searchKey = $request->search;
        }

        if ($request->searchCity) {
            $areas->where('city_id', $request->searchCity);
            $searchCity = $request->searchCity;
        }

        $areas = $areas->whereHas('city', function($q){
            $q->where('is_active', 1);
        })->with('city')->orderBy('is_active', 'desc')->paginate(paginationNumber(30));

        // return $areas;
        
        return view('backend.pages.fulfillments.areas.index', compact('areas', 'searchKey', 'searchCity'));
    }

    # return view of create form
    public function create()
    {
        $cities = City::where('is_active', 1)->get();
        return view('backend.pages.fulfillments.areas.create', compact('cities'));
    }

    # store new area
    public function store(Request $request)
    {
        $area = new Area;
        $area->name      = $request->name;
        $area->city_id   = $request->city_id;
        $area->minimum_order_price   = $request->minimum_order_price;
        $area->is_active = 1;
        $area->save();
        flash(localize('Area has been inserted successfully'))->success();
        return redirect()->route('admin.areas.index');
    }

    # return view of edit form
    public function edit($id)
    {
        $cities = City::where('is_active', 1)->get();
        $area = Area::findOrFail($id);
        return view('backend.pages.fulfillments.areas.edit', compact('cities', 'area'));
    }

    # update area  
    public function update(Request $request)
    {
        $area = Area::findOrFail((int) $request->id);
        $area->name    = $request->name;
        $area->city_id = $request->city_id;
        $area->minimum_order_price   = $request->minimum_order_price;
        $area->is_active =  $request->is_active;
        $area->save();
        flash(localize('Area has been updated successfully'))->success();
        return back();
    }

    # update status 
    public function updateStatus(Request $request)
    {
        $area = Area::findOrFail($request->id);
        $area->is_active = $request->is_active;
        $area->save();
        flash(localize('Status updated successfully'))->success();
        return 1;
    }
}
