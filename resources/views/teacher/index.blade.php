@extends('layouts.app', ['partition' => 'main', 'page' => 'main'])

@section('content')
    <div class="kt-portlet">
        <div class="kt-portlet__body  kt-portlet__body--fit">
            <div class="row row-no-padding row-col-separator-lg">
                <div class="col-md-12 col-lg-4 col-xl-4">
                    <div class="kt-widget24">
                        <div class="kt-widget24__details">
                            <div class="kt-widget24__info">
                                <h4 class="kt-widget24__title">{{ __('pages.count-lessons') }}</h4>
                                <span class="kt-widget24__desc">{{ __('pages.count-lessons-desc') }}</span>
                            </div>
                            <span class="kt-widget24__stats kt-font-brand" style="white-space: nowrap">
                                {{ $dashboardsData->get('count_lessons') }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4 col-xl-4">
                    <div class="kt-widget24">
                        <div class="kt-widget24__details">
                            <div class="kt-widget24__info">
                                <h4 class="kt-widget24__title">{{ __('pages.indiv-lessons') }}</h4>
                            </div>
                            <span class="kt-widget24__stats kt-font-brand" style="white-space: nowrap">
                                <span class="text-success">{{ $dashboardsData->get('visits')['single']['attendance'] }}</span>
                                <span>/</span>
                                <span class="text-warning">{{ $dashboardsData->get('visits')['single']['absence'] }}</span>
                            </span>
                        </div>
                        <div class="kt-widget24__details">
                            <div class="kt-widget24__info">
                                <h4 class="kt-widget24__title">{{ __('pages.group-lessons') }}</h4>
                            </div>
                            <span class="kt-widget24__stats kt-font-brand" style="white-space: nowrap">
                                <span class="text-success">{{ $dashboardsData->get('visits')['group']['attendance'] }}</span>
                                <span>/</span>
                                <span class="text-warning">{{ $dashboardsData->get('visits')['group']['absence'] }}</span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4 col-xl-4">
                    <div class="kt-widget24">
                        <div class="kt-widget24__details">
                            <div class="kt-widget24__info">
                                <h4 class="kt-widget24__title">{{ __('pages.salary-earned') }}</h4>
                            </div>
                            <span class="kt-widget24__stats kt-font-info text-right">
                                {{ $dashboardsData->get('salary_earned') }}
                                <i class="fa fa-ruble-sign"></i>
                            </span>
                        </div>
                        <div class="kt-widget24__details">
                            <div class="kt-widget24__info">
                                <h4 class="kt-widget24__title">{{ __('pages.salary-payed') }}</h4>
                            </div>
                            <span class="kt-widget24__stats kt-font-info text-right">
                                {{ $dashboardsData->get('salary_payed') }}
                                <i class="fa fa-ruble-sign"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Расписание занятий-->
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="kt-portlet kt-portlet--height-fluid kt-portlet--mobil ">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            <i class="fa fa-calendar kt-font-brand"></i>
                            &nbsp;
                            {{ __('pages.schedule-short') }}
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <form action="{{ route('teacher.index') }}" method="get">
                            <div class="input-group date">
                                <input type="text" name="date" class="form-control" value="{{ $date->format('d.m.Y') }}" readonly="" id="kt_teacher_short_schedule_datepicker">
                                <div class="input-group-append">
                                    <button class="btn btn-primary">
                                        <i class="fa flaticon2-search" style="color: #fff"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="kt-portlet__body kt-portlet__body--fit">
                    <div class="schedule-short table-responsive" id="kt_datatable_teacher_schedule_short">
                        <table class="table" style="min-width: 640px;">
                            @foreach($weeks as $week)
                                <tr>
                                    @foreach($week as $day)
                                        <td>
                                            <span class="date @if($day['date'] == $date->format('Y-m-d')) date-active @endif">
                                                {{ date('d.m.Y', strtotime($day['date'])) }}
                                            </span>
                                            @foreach($day['areas'] as $area)
                                                <span class="area">{{ $area->title }}</span>
                                                @foreach($area->lessons as $lesson)
                                                    <p class="lesson @if(!is_null($lesson->report ?? null)) reported @endif">
                                                        <span class="time">
                                                            {{ $lesson->refactored_time_from }} - {{ $lesson->refactored_time_to }}
                                                        </span>
                                                        <span> </span>
                                                        <span class="client">
                                                            @if (!empty($lesson->client))
                                                                {{ $lesson->client->surname }}
                                                            @elseif (!empty($lesson->group))
                                                                {{ $lesson->group->title }}
                                                            @elseif (!empty($lesson->lid))
                                                                {{ __('pages.consult') }}
                                                            @endif
                                                        </span>
                                                    </p>
                                                @endforeach
                                            @endforeach
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end: Расписание занятий-->

    <div class="row">
        <!--start: Таблица с отчетами о проведенных занятиях-->
        <div class="col-md-8 col-sm-12">
            <div class="kt-portlet kt-portlet--height-fluid kt-portlet--mobil ">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            <i class="fa fa-clipboard-list kt-font-brand"></i>
                            &nbsp;
                            {{ __('pages.reports-table') }}
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                    </div>
                </div>
                <div class="kt-portlet__body kt-portlet__body--fit">
                    <div class="reports-table" id="kt_datatable_teacher_schedule_short">
                        <table class="table">
                            <tr>
                                <th class="text-center">{{ __('pages.date') }}</th>
                                <th class="text-center">{{ __('pages.time') }}</th>
                                <th>{{ __('pages.reports-results') }}</th>
                                <th class="text-center">{{ __('pages.actions') }}</th>
                            </tr>
                            @foreach($todayLessons as $lesson)
                                <tr class="text-center">
                                    <td>{{ $date->format('d.m.y') }}</td>
                                    <td>{{ $lesson->refactored_time_from }} - {{ $lesson->refactored_time_to }}</td>
                                    <td class="text-left">
                                        <form action="{{ route('schedule.lesson_report') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="{{ \App\Api\Facade::PARAM_LESSON_ID }}" value="{{ $lesson->id }}">
                                            <input type="hidden" name="{{ \App\Api\Facade::PARAM_LESSON_ATTENDANCE }}" value="0">
                                            <input type="hidden" name="{{ \App\Api\Facade::PARAM_DATE }}" value="{{ $date->format('Y-m-d') }}">
                                            <input type="hidden" name="{{ \App\User::REQUEST_TOKEN }}">

                                            <input type="checkbox" id="attendance_{{ $lesson->id }}" value="1" name="attendance" @if(!is_null($lesson->report ?? null)) disabled @endif @if($lesson->report->attendance ?? null) checked @endif>
                                            @if (!is_null($lesson->client ?? null))
                                                <label for="attendance_{{ $lesson->id }}">
                                                    {{ $lesson->client->surname }} {{ $lesson->client->name }}
                                                </label>
                                            @elseif (!is_null($lesson->group ?? null))
                                                <label for="attendance_{{ $lesson->id }}">
                                                    {{ $lesson->group->title }}
                                                </label>
                                                <a data-toggle="collapse" href="#report_attendance_list_{{ $lesson->id }}" role="button" aria-expanded="false" aria-controls="report_attendance_list_{{ $lesson->id }}">
                                                    {{ __('pages.reports-group-clients') }}
                                                </a>
                                                <ul id="report_attendance_list_{{ $lesson->id }}" class="list-unstyled report-attendance-list collapse">
                                                    @foreach($lesson->group->clients ?? [] as $client)
                                                        <li>
                                                            <input type="hidden" name="{{ \App\Api\Facade::PARAM_LESSON_ATTENDANCE_CLIENTS }}[{{ $client->id }}]" value="0">
                                                            <input type="checkbox"
                                                                   id="attendance_clients_{{ $client->id }}"
                                                                   name="{{ \App\Api\Facade::PARAM_LESSON_ATTENDANCE_CLIENTS }}[{{ $client->id }}]"
                                                                   value="1"
                                                                   @if (collect($lesson->report->attendances ?? [])->where('client_id', $client->id)->first()->attendance ?? null) checked @endif
                                                                   @if (!is_null($lesson->report)) disabled @endif
                                                            >
                                                            <label for="attendance_clients_{{ $client->id }}">
                                                                {{ $client->surname }} {{ $client->name }}
                                                            </label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <label for="attendance_{{ $lesson->id }}">
                                                    {{ __('pages.consult') }}
                                                </label>
                                            @endif
                                        </form>
                                    </td>
                                    <td>
                                        @if (is_null($lesson->report ?? null))
                                            <a href="#" class="btn btn-primary makeReport" data-lesson-id="{{ $lesson->id }}">
                                                <i class="fa fa-save"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--end: Таблица с отчетами о проведенных занятиях-->

        <!--start: Таблица с клиентами-->
        <div class="col-md-4 col-sm-12">
            <div class="kt-portlet kt-portlet--height-fluid kt-portlet--mobil">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            <i class="fa flaticon-users-1 kt-font-brand"></i>
                            &nbsp;
                            {{ __('pages.clients-table') }}
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                    </div>
                </div>
                <div class="kt-portlet__body @if($clients->isNotEmpty()) kt-portlet__body--fit @endif">
                    @if($clients->isEmpty())
                        <div class="row">
                            <div class="col-md-6 col-sm-12 offset-md-3 offset-sm-0">
                                <div class="alert alert-outline-danger fade show" role="alert">
                                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                    <div class="alert-text">
                                        {{ __('pages.clients-empty-error') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table">
                                <tr class="text-center">
                                    <th>{{ __('pages.client-name') }}</th>
                                    <th>{{ __('pages.phone-number') }}</th>
                                </tr>
                                @foreach($clients as $client)
                                    <tr class="text-center">
                                        <td>
                                            {{ $client->surname }} {{ $client->name }}
                                        </td>
                                        <td>
                                            {{ $client->phone_number }}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <!--end: таблица с клиентами-->
    </div>
@endsection
