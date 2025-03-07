@extends('layouts.app', ['page' => 'main'])

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
                            <span class="kt-widget24__stats kt-font-brand" style="white-space: nowrap">
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
                                @if($user->balance->individual_lessons_count >= 1)      kt-font-success
                                @elseif($user->balance->individual_lessons_count < 0)   kt-font-danger
                                @else                                                   kt-font-warning
                            @endif">
                                {{ $user->balance->individual_lessons_count }}
                            </span>
                        </div>
                        <div class="kt-widget24__details">
                            <div class="kt-widget24__info">
                                <h4 class="kt-widget24__title">{{ __('pages.group-lessons') }}</h4>
                            </div>
                            <span class="kt-widget24__stats
                                @if($user->balance->group_lessons_count >= 1)       kt-font-success
                                @elseif($user->balance->group_lessons_count < 0)    kt-font-danger
                                @else                                               kt-font-warning
                            @endif">{{ $user->balance->group_lessons_count }}</span>
                        </div>
                    </div>
                    <!--end::New Feedbacks-->
                </div>
                <div class="col-md-12 col-lg-4 col-xl-4">
                    <div class="kt-widget24">
                        <div class="kt-widget24__details">
                            <div class="kt-widget24__info">
                                <h4 class="kt-widget24__title">{{ __('pages.next-lesson') }}</h4>
                                @if(!empty($nextLessons->date))
                                    @foreach($nextLessons->lessons as $lesson)
                                        <span class="kt-widget24__desc">
                                            <br>{{ $lesson->area->title }}: <span style="white-space: nowrap">{{ $lesson->refactored_time_from }} - {{ $lesson->refactored_time_to }}</span>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--end:: Widgets/Stats-->

    <div class="row">
        <div class="col-md-8 col-sm-12">
            <div class="kt-portlet kt-portlet--height-fluid kt-portlet--mobil ">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            <i class="fa fa-money-bill kt-font-brand"></i>
                            &nbsp;
                            {{ __('pages.payments-history') }}
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <a class="btn btn-primary btn-sm" data-toggle="kt-tooltip" href="{{ route('balance.index') }}">
                            {{ __('pages.make-payment') }}
                        </a>
                    </div>
                </div>
                <div class="kt-portlet__body kt-portlet__body--fit">
                    <div class="kt-datatable" id="kt_datatable_payments_history"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="kt-portlet kt-portlet--height-fluid kt-portlet--mobile ">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title" >
                            <i class="flaticon-event-calendar-symbol kt-font-brand"></i>
                            &nbsp;{{ __('pages.schedule.absent_period') }}
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <a class="btn btn-primary btn-sm" data-toggle="kt-tooltip" href="javascript:$('#absentPeriodModal').modal();">
                            {{ __('pages.add') }}
                        </a>
                    </div>
                </div>
                <div class="kt-portlet__body kt-portlet__body--fit">
                    <div class="kt-datatable" id="kt_datatable_absent_periods"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="kt-portlet kt-portlet--height-fluid kt-portlet--mobile ">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title" style="width: 110px;">
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
                        &nbsp;
                        <a class="btn btn-success btn-sm" data-toggle="kt-tooltip" href="{{ route('schedule.find_teacher_time') }}">
                            {{ __('pages.get-teacher-time') }}
                        </a>
                    </div>
                </div>
                <div class="kt-portlet__body kt-portlet__body--fit">
                    <div class="kt-datatable" id="kt_datatable_schedule"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12">
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

    <!--Модалка для создания периода отсутствия-->
    <div class="modal fade" id="absentPeriodModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('pages.absent-period-create-title') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('schedule.absents.save') }}" method="POST" id="absentPeriodForm">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="token" value="{{ \App\User::getToken() }}">
                        <div class="row">
                            <div class="col-md-4 col-sm-12 text-right">
                                <label for="period-date-from" class="form-label">{{ __('pages.absent-period-date-from') }}</label>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <input type="date" id="period-date-from" class="form-control" name="date_from">
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-md-4 col-sm-12 text-right">
                                <label for="period-date-to" class="form-label">{{ __('pages.absent-period-date-to') }}</label>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <input type="date" id="period-date-to" class="form-control" name="date_to">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('pages.cancel') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('pages.create') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
