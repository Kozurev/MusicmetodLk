@extends('layouts.app', ['partition' => 'schedule', 'page' => 'schedule'])

@section('content')
    <!--Расписание занятий-->
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="kt-portlet kt-portlet--height-fluid kt-portlet--mobil ">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            <i class="fa fa-calendar kt-font-brand"></i>
                            &nbsp;
                            {{ __('pages.schedule-full') }}
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">

                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 offset-md-3 offset-sm-0">
                            <form action="{{ route('teacher.schedule') }}" method="get">
                                <div class="row">
                                    <div class="col-md-6">
                                        <select name="area_id" id="" class="form-control">
                                            @if($areas->isEmpty())
                                                <option value="">{{ __('pages.areas-empty') }}</option>
                                            @else
                                                @foreach($areas as $area)
                                                    <option value="{{ $area->id }}" @if($areaId == $area->id) selected @endif>
                                                        {{ $area->title }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group date">
                                            <input type="text" name="date" class="form-control datepicker" value="{{ $date->format('d.m.Y') }}">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary">
                                                    <i class="fa flaticon2-search" style="color: #fff"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__body @if($areas->isNotEmpty()) kt-portlet__body--fit @endif">
                    @if($areas->isEmpty())
                        <div class="row">
                            <div class="col-md-6 col-sm-12 offset-md-3 offset-sm-0">
                                <div class="alert alert-outline-danger fade show" role="alert">
                                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                    <div class="alert-text">
                                        {{ __('pages.areas-empty-error') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="schedule-full table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        @foreach($schedule as $class)
                                            <th colspan="2" class="text-center" width="{{ 100 / $schedule->count() }}%">{{ $class->title }}</th>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        @foreach($schedule as $class)
                                            <td width="60px">{{ __('pages.time') }}</td>
                                            <td>{{ __('pages.lessons') }}</td>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $lastClassLesson = collect();
                                    @endphp
                                    @while($timeStart->format('H:i:s') < $timeEnd->format('H:i:s'))
                                        <tr>
                                            @foreach($schedule as $class)
                                                <td class="cell cell-time">
                                                    {{ $timeStart->format('H:i') }}
                                                </td>
                                                @php
                                                    $minLessonTimeStart = $timeStart->format('H:i:s');
                                                    $maxLessonTimeStart = (clone $timeStart)->addMinutes($timeMinutesStep)->format('H:i:s');
                                                    $lesson = collect($class->current_lessons)
                                                        ->where('time_from', '>=', $minLessonTimeStart)
                                                        ->where('time_from', '<', $maxLessonTimeStart)
                                                        ->first();

                                                    $isNewLesson = !is_null($lesson) && $lesson !== $lastClassLesson->get($class->class_id);

                                                    if ($isNewLesson) {
                                                        $countMinutes = (strtotime($lesson->time_to) - strtotime($lesson->time_from)) / 60;
                                                        $rowspan = intval($countMinutes / $timeMinutesStep) + intval(boolval($countMinutes % $timeMinutesStep));
                                                    }
                                                @endphp
                                                @if(is_null($lesson) && $timeStart->format('H:i:s') < ($lastClassLesson->get($class->class_id)->time_to ?? '00:00:00'))
                                                    @continue
                                                @else
                                                    <td class="cell @if(is_null($lesson)) cell-empty @elseif($lesson->teacher_id != $user->id) cell-blocked @else cell-self @endif"
                                                        @if(!is_null($lesson)) rowspan="{{ $rowspan }}" @endif>

                                                        @if(!is_null($lesson) && $lesson->teacher_id == $user->id)
                                                            @if(in_array($lesson->type_id, [\App\Api\Schedule::TYPE_SINGLE, \App\Api\Schedule::TYPE_PRIVATE]))
                                                                @if($lesson->client->surname ?? null)
                                                                    {{ $lesson->client->surname }} {{ $lesson->client->name }}
                                                                @else
                                                                    {{ __('pages.schedule-undefined-client') }}
                                                                @endif
                                                            @elseif(in_array($lesson->type_id, [\App\Api\Schedule::TYPE_GROUP, \App\Api\Schedule::TYPE_GROUP_CONSULT]))
                                                                @if($lesson->client->title ?? null)
                                                                    {{ $lesson->client->title }}
                                                                @else
                                                                    {{ __('pages.schedule-undefined-group') }}
                                                                @endif
                                                            @else
                                                                @if($lesson->client->number ?? null)
                                                                    {{ __('pages.schedule-consult') }} {{ $lesson->client->number }}
                                                                @else
                                                                    {{ __('pages.schedule-undefined-lid') }}
                                                                @endif
                                                            @endif
                                                        @endif
                                                    </td>
                                                @endif
                                                @php
                                                    if(!is_null($lesson)) $lastClassLesson->put($class->class_id, $lesson);
                                                @endphp
                                            @endforeach
                                        </tr>
                                        @php
                                            $timeStart->addMinutes($timeMinutesStep);
                                        @endphp
                                    @endwhile
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!--end: Расписание занятий-->
@endsection
