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
                        @if(!empty($error))
                            {{ __('pages.error') }}
                        @else
                            {!! __('pages.rate-buy-submit-title', ['rate' => $rate->title]) !!}
                        @endif
                    </h5>
                    <p>
                        @if(!empty($error))
                            {{ $error }}
                        @else
                            {!! __('pages.rate-buy-submit-description', ['amount' => $rate->price]) !!}
                        @endif
                    </p>
                </div>
            </div>
            @if(empty($error))
                <div class="kt-pricing-1__items row">
                    <div class="col-lg-9 col-xl-6">
                        <form method="POST" action="{{ route('rate.buy.execute', ['id' => $rate->id]) }}" id="confirmRateBuy">
                            @if(empty($error))
                                @csrf
                                <a href="#" onclick="$('#confirmRateBuy').submit(); return false;" class="btn btn-success btn-bold">
                                    {{ __('pages.submit') }}
                                </a>
                            @endif
                            <a href="{{ route('rates.index') }}" class="btn btn-danger btn-bold">{{ __('pages.cancel') }}</a>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection