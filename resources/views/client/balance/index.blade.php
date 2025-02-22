@extends('layouts.app', ['partition' => 'balance', 'page' => 'balance.index'])

@section('content')
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="kt-menu__link-bullet flaticon-piggy-bank"><span>&nbsp;</span></i>
            </span>
                <h3 class="kt-portlet__head-title">
                    {{ __('pages.balance-incrementing-title') }}
                </h3>
            </div>
        </div>
{{--        {{ dd($errors->has('amount'), $errors->first('amount')) }}--}}
        <div class="kt-portlet__body">
            <div class="kt-pricing-1 kt-pricing-1--fixed">
                <form method="GET" action="{{ route('balance.makeDeposit') }}">
                    <div class="kt-pricing-1__items row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12 text-right">{{ __('pages.input-amount') }}</label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                        <span class="input-group-btn input-group-prepend">
                                            <button class="btn btn-secondary bootstrap-touchspin-down" type="button">-</button>
                                        </span>
                                        <span class="input-group-addon bootstrap-touchspin-prefix input-group-prepend">
                                            <span class="input-group-text">₽</span>
                                        </span>
                                        <input type="text" class="form-control" value="1000" name="amount" placeholder="{{ __('pages.input-amount') }}">
                                        <span class="input-group-btn input-group-append">
                                            <button class="btn btn-secondary bootstrap-touchspin-up" type="button">+</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-pricing-1__items row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
{{--                            @if($errors->any())--}}
{{--                                @foreach($errors->all() as $error)--}}
{{--                                    <div class="alert alert-danger fade show" role="alert">--}}
{{--                                        <div class="alert-icon"><i class="flaticon-warning"></i></div>--}}
{{--                                        <div class="alert-text">{{ $error }}</div>--}}
{{--                                        <div class="alert-close">--}}
{{--                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
{{--                                                <span aria-hidden="true"><i class="la la-close"></i></span>--}}
{{--                                            </button>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                @endforeach--}}
{{--                            @endif--}}

                            <div class="form-group form-group-last">
                                <div class="alert alert-secondary" role="alert">
                                    <div class="alert-icon"><i class="flaticon-questions-circular-button"></i></div>
                                    <div class="alert-text">
                                        {!! __('pages.balance-incrementing-desc', ['link' => config('app.policy_link')]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-pricing-1__items row">
                        <div class="col-lg-9 col-xl-6">
{{--                            <a href="#" onclick="$('#confirmPayment').submit(); return false;" class="btn btn-success btn-bold">--}}
{{--                                {{ __('pages.balance-increment') }}--}}
{{--                            </a>--}}
                            <button type="submit" class="btn btn-success btn-bold">
                                {{ __('pages.balance-increment') }}
                            </button>
                            <a href="{{ route('rates.index') }}" class="btn btn-danger btn-bold">{{ __('pages.cancel') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
