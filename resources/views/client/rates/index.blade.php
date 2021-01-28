@extends('layouts.app', ['partition' => 'balance', 'page' => 'rates.index'])

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="kt-portlet kt-portlet--height-fluid kt-portlet--mobil ">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            <i class="kt-menu__link-bullet flaticon2-shopping-cart-1"></i>
                            &nbsp
                            {{ __('pages.rates') }}
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body kt-portlet__body--fit">
                    <div class="kt-datatable" id="kt_datatable_rates"></div>
                </div>
            </div>
        </div>
    </div>
@endsection