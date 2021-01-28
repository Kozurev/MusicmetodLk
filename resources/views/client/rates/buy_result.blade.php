@extends('layouts.app', ['partition' => 'balance', 'page' => 'rates.index'])

@section('content')
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon2-shopping-cart-1"></i>
            </span>
                <h3 class="kt-portlet__head-title">
                    {{ __('pages.rate-buy') }}
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="kt-pricing-1 kt-pricing-1--fixed">
                <div class="kt-pricing-1__items row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <h5>
                            @if(!empty($result->error))
                                {!! __('pages.rate-buy-error-title') !!}
                            @else
                                {!! __('pages.rate-buy-success-title', ['rate' => $result->tarif->title]) !!}
                            @endif
                        </h5>
                        <p>
                            @if(!empty($result->error))
                                {{ $result->message }}
                            @endif
                        </p>
                    </div>
                </div>
                <div class="kt-pricing-1__items row">
                    <div class="col-lg-9 col-xl-6">
                        <a href="{{ route('rates.index') }}" class="btn btn-danger btn-bold">{{ __('pages.back') }}</a>
                        <a href="{{ route('index') }}" class="btn btn-primary btn-bold">{{ __('pages.to-main') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection