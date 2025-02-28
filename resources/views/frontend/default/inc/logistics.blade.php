<h4 class="mt-7">{{ localize('Available Logistics') }}</h4>
@forelse ($logisticZoneAreas as $zoneArea)
    @if ($zoneArea->logistic && $zoneArea->logisticZone)
        <div class="checkout-radio d-flex align-items-center justify-content-between gap-3 bg-white rounded p-4 mt-3">
            <div class="radio-left d-inline-flex align-items-center">
                <div class="theme-radio">
                    <input type="radio" name="chosen_logistic_zone_id" id="logistic-{{ $zoneArea->logistic_zone_id }}"
                        value="{{ $zoneArea->logistic_zone_id }}">
                    <span class="custom-radio"></span>
                </div>
                <div>
                    <label for="logistic-{{ $zoneArea->logistic_zone_id }}" class="ms-3 mb-0">
                        <div class="h6 mb-0">{{ $zoneArea->logistic->name }}</div>
                        <div> {{ localize('Shipping Charge') }}
                            {{ formatPrice($zoneArea->logisticZone->standard_delivery_charge) }}</div>
                    </label>
                </div>
            </div>
            <div class="radio-right text-end">
                <img src="{{ uploadedAsset($zoneArea->logistic->thumbnail_image) }}" alt="{{ $zoneArea->logistic->name }}"
                    class="img-fluid">
            </div>
        </div>
    @else
        {{-- <div class="col-12 mt-5">
            <div class="tt-address-content">
                <div class="alert alert-danger text-center">
                    {{ localize('Logistic information is missing for this area.') }}
                </div>
            </div>
        </div> --}}
    @endif
@empty
    <div class="col-12 mt-5">
        <div class="tt-address-content">
            <div class="alert alert-danger text-center">
                {{ localize('We are not shipping to your area now.') }}
            </div>
        </div>
    </div>
@endforelse
