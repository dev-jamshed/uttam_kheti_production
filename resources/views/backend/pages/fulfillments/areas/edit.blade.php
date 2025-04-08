@extends('backend.layouts.master')

@section('title')
    {{ localize('Update Area') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection


@section('contents')
    <section class="tt-section pt-4">
        <div class="container">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card tt-page-header">
                        <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                            <div class="tt-page-title">
                                <h2 class="h5 mb-lg-0">{{ localize('Update Area') }} </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4 g-4">

                <!--left sidebar-->
                <div class="col-xl-9 order-2 order-md-2 order-lg-2 order-xl-1">
                    <form action="{{ route('admin.areas.update') }}" method="POST" class="pb-650">
                        @csrf
                        <input type="hidden" name="id" value="{{ $area->id }}">
                        <!--basic information start-->
                        <div class="card mb-4" id="section-1">
                            <div class="card-body">
                                <h5 class="mb-4">{{ localize('Basic Information') }}</h5>

                                <div class="mb-4">
                                    <label for="name" class="form-label">{{ localize('Area Name') }}</label>
                                    <input class="form-control" type="text" id="name"
                                        placeholder="{{ localize('Type area name') }}" name="name" required
                                        value="{{ $area->name }}">
                                </div>

                                <div class="mb-4">
                                    <label for="minimum_order_price" class="form-label">
                                        {{ localize('Minimum Order Price') }} 
                                        <small>(This field is used to set the minimum order price for the area)</small>
                                    </label>
                                    <input class="form-control" type="number" id=""
                                        placeholder="{{ localize('Enter minimum order price') }}" name="minimum_order_price" value="{{ $area->minimum_order_price }}" required>
                                </div>

                                <div class="mb-4">
                                    <label for="city_id" class="form-label">{{ localize('City') }}</label>
                                    <select class="form-control select2" name="city_id" class="w-100"
                                        data-toggle="select2" required>
                                        <option value="">{{ localize('Select a City') }}</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}"
                                                {{ $area->city->id == $city->id ? 'selected' : '' }}>
                                                {{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label for="is_active" class="form-label">{{ localize('Active') }}</label>
                                    <select class="form-control select2" name="is_active" class="w-100" required>
                                        <option value="1" {{ $area->is_active ? 'selected' : '' }}>{{ localize('Active') }}</option>
                                        <option value="0" {{ !$area->is_active ? 'selected' : '' }}>{{ localize('Inactive') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!--basic information end-->

                        <!-- submit button -->
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-4">
                                    <button class="btn btn-primary" type="submit">
                                        <i data-feather="save" class="me-1"></i> {{ localize('Save Changes') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- submit button end -->

                    </form>
                </div>

                <!--right sidebar-->
                <div class="col-xl-3 order-1 order-md-1 order-lg-1 order-xl-2">
                    <div class="card tt-sticky-sidebar d-none d-xl-block">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Logistic Information') }}</h5>
                            <div class="tt-vertical-step">
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="#section-1" class="active">{{ localize('Basic Information') }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
