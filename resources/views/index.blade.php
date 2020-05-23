@extends('layouts.app', ['page' => 'index'])

@section('content')
    <div class="kt-portlet">
        <div class="kt-portlet__body  kt-portlet__body--fit">
            <div class="row row-no-padding row-col-separator-lg">
                <div class="col-md-12 col-lg-4 col-xl-4">
                    <!--begin::Total Profit-->
                    <div class="kt-widget24">
                        <div class="kt-widget24__details">
                            <div class="kt-widget24__info">
                                <h4 class="kt-widget24__title">{{ __('pages.balance') }}</h4>
                                <span class="kt-widget24__desc">{{ __('pages.balance-tab-desc') }}</span>
                            </div>
                            <span class="kt-widget24__stats kt-font-brand">
                                {{ \App\Format::amount($user->balance->amount) }}
                                <i class="fa fa-ruble-sign"></i>
                            </span>
                        </div>
                    </div>
                    <!--end::Total Profit-->
                </div>
                <div class="col-md-12 col-lg-4 col-xl-4">
                    <!--begin::New Feedbacks-->
                    <div class="kt-widget24">
                        <div class="kt-widget24__details">
                            <div class="kt-widget24__info">
                                <h4 class="kt-widget24__title">{{ __('pages.indiv-lessons') }}</h4>
                            </div>
                            <span class="kt-widget24__stats
                                @if($user->balance->lessons_indiv >= 1)         kt-font-success
                                @elseif($user->balance->lessons_indiv < 0)      kt-font-danger
                                @else                                           kt-font-warning
                            @endif">
                                {{ $user->balance->lessons_indiv }}
                            </span>
                        </div>
                        <div class="kt-widget24__details">
                            <div class="kt-widget24__info">
                                <h4 class="kt-widget24__title">{{ __('pages.group-lessons') }}</h4>
                            </div>
                            <span class="kt-widget24__stats
                                @if($user->balance->lessons_group >= 1)         kt-font-success
                                @elseif($user->balance->lessons_group < 0)      kt-font-danger
                                @else                                           kt-font-warning
                            @endif">{{ $user->balance->lessons_group }}</span>
                        </div>
                    </div>
                    <!--end::New Feedbacks-->
                </div>
                <div class="col-md-12 col-lg-4 col-xl-4">
                    <!--begin::New Users-->
                    <div class="kt-widget24">
                        <div class="kt-widget24__details">
                            <div class="kt-widget24__info">
                                <h4 class="kt-widget24__title">{{ __('pages.next-lesson') }}</h4>
                                @if(!empty($nextLessons->date))
                                    @foreach($nextLessons->lessons as $lesson)
                                        <span class="kt-widget24__desc">
                                            {{ $lesson->area->title }} <br/> {{ $lesson->refactored_time_from }} - {{ $lesson->refactored_time_to }}
                                        </span>
                                    @endforeach
                                @endif
                            </div>
                            <span class="kt-widget24__stats kt-font-success text-right">
                                @if(!empty($nextLessons->date))
                                    {{ \App\Format::date($nextLessons->date ?? '') }}
                                @else
                                    {{ __('pages.next-lessons-none') }}
                                @endif
                            </span>
{{--                            <a href="{{ route('schedule.index') }}" class="btn-btn-primary"></a>--}}
                        </div>
                    </div>
                    <!--end::New Users-->
                </div>
            </div>
        </div>
    </div>

    <!--end:: Widgets/Stats-->

    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="kt-portlet kt-portlet--height-fluid kt-portlet--mobil ">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            <i class="fa fa-money-bill kt-font-brand"></i>
                            &nbsp;
                            {{ __('pages.payments-history') }}
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body kt-portlet__body--fit">
                    <div class="kt-datatable" id="kt_datatable_payments_history"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="kt-portlet kt-portlet--height-fluid kt-portlet--mobile">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            <i class="fa fa-history kt-font-brand"></i>
                            &nbsp;
                            {{ __('pages.schedule-history') }}
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body kt-portlet__body--fit">
                    <div class="kt-datatable" id="kt_datatable_schedule_history"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-sm-12">
            <div class="kt-portlet kt-portlet--height-fluid kt-portlet--mobile ">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            <i class="flaticon-event-calendar-symbol kt-font-brand"></i>
                            &nbsp;{{ __('pages.schedule') }}
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <a class="btn btn-primary btn-sm kt-subheader__btn-daterange" id="schedule_kt_dashboard_daterangepicker" data-toggle="kt-tooltip" title="{{ __('daterange.title') }}" data-placement="left">
                            <span class="kt-subheader__btn-daterange-title" id="schedule_kt_dashboard_daterangepicker_title"></span>&nbsp;
                            <span class="kt-subheader__btn-daterange-date" id="schedule_kt_dashboard_daterangepicker_date"></span>
                        </a>
                        <input type="hidden" class="form-control" id="schedule_kt_dashboard_daterangepicker_val">
                    </div>
                </div>
                <div class="kt-portlet__body kt-portlet__body--fit">
                    <div class="kt-datatable" id="kt_datatable_schedule"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
