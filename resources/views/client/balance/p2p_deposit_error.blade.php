@extends('layouts.app', ['partition' => 'balance', 'page' => 'balance.p2p.deposit.error'])

@section('content')
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="kt-menu__link-bullet flaticon-piggy-bank"><span>&nbsp;</span></i>
            </span>
                <h3 class="kt-portlet__head-title">
                    {{ __('pages.p2p-transaction-created-error-title') }}
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="kt-pricing-1 kt-pricing-1--fixed">
                <div class="kt-pricing-1__items row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <p>
                            {{ __('pages.p2p-transaction-created-error-text', ['error' => $error]) }}
                        </p>
                    </div>
                </div>
                <hr>
                <div class="kt-pricing-1__items row">
                    <div class="col-lg-9 col-xl-6">
                        <a href="{{ route('index') }}" class="btn btn-primary btn-bold">{{ __('pages.to-main') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
