@extends('layouts.app', ['partition' => 'schedule', 'page' => 'schedule'])

@section('content')
{{--    {{ dd($errors->any()) }}--}}
    <!--Расписание занятий-->
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="kt-portlet kt-portlet--height-fluid kt-portlet--mobil ">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            <i class="kt-menu__link-icon flaticon-event-calendar-symbol kt-font-brand"></i>
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
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa flaticon2-search" style="color: #fff"></i>
                                                </button>
                                                @if($areas->isNotEmpty() && $schedule->isNotEmpty())
                                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#teacherLessonModal">
                                                        <i class="fa fa-plus" style="color: #fff"></i>
                                                    </button>
                                                @endif
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

@section('modals')
    <!-- Modal -->
    <div class="modal fade" id="teacherLessonModal" tabindex="-1" role="dialog" aria-labelledby="teacherLessonModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="teacherLessonModalLabel">
                        {{ __('pages.schedule-create-lesson-title') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('teacher.schedule.lesson.save') }}" method="POST" id="teacherLessonForm">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="token" value="{{ \App\User::getToken() }}">
                        <input type="hidden" name="area_id" value="{{ $areaId }}">
                        <input type="hidden" name="date" value="{{ $date->format('Y-m-d') }}">

                        <div class="row">
                            <div class="col-md-4 col-sm-12 text-right">
                                <div class="form-group">
                                    <label for="type_id" class="form-label">{{ __('pages.lesson-type') }}</label>
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-12">
                                <div class="form-group">
                                    <select name="type_id" id="type_id" class="form-control">
                                        @foreach($lessonTypes as $typeId => $typeName)
                                            <option value="{{ $typeId }}">
                                                {{ $typeName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-12 text-right">
                                <div class="form-group">
                                    <label for="class_id" class="form-label">{{ __('pages.class') }}</label>
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-12">
                                <div class="form-group">
                                    <select name="class_id" id="class_id" class="form-control">
                                        @foreach($schedule as $class)
                                            <option value="{{ $class->class_id }}">
                                                {{ $class->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-12 text-right">
                                <div class="form-group">
                                    <label for="client_id" class="form-label">{{ __('pages.client') }}</label>
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-12">
                                <div class="form-group">
                                    <select name="client_id" id="client_id" class="form-control">
                                        @foreach($clients as $client)
                                            <option value="{{ $client->id }}">
                                                {{ $client->surname }} {{ $client->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-12 text-right">
                                <div class="form-group">
                                    <label for="lesson_time_from" class="form-label">{{ __('pages.lesson-time-from') }}</label>
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-12">
                                <div class="form-group">
                                    <input type="time" class="form-control" name="lesson_time_from" id="lesson_time_from" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-12 text-right">
                                <div class="form-group">
                                    <label for="lesson_time_to" class="form-label">{{ __('pages.lesson-time-to') }}</label>
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-12">
                                <div class="form-group">
                                    <input type="time" class="form-control" name="lesson_time_to" id="lesson_time_to" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('pages.cancel') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('pages.schedule-create-lesson-submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection