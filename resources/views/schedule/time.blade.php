@extends('layouts.app', ['partition' => 'schedule', 'page' => 'schedule.find_teacher_time'])

@section('content')
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="kt-menu__link-bullet flaticon-clock-2"><span>&nbsp;</span></i>
            </span>
                <h3 class="kt-portlet__head-title">
                    {{ __('pages.schedule.find_teacher_time') }}
                </h3>
            </div>
        </div>

        <div class="kt-portlet__body">
            <div class="kt-pricing-1 kt-pricing-1--fixed">
                <div class="kt-pricing-1__items row">
                    <div class="col-lg-6">
                        <form method="GET" action="{{ route('schedule.find_teacher_time') }}">
                            @if($customErrors->count() == 0)
                                <div class="kt-pricing-1__items row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-4 col-md-4 col-sm-12 text-right" for="teacherId">
                                                {{ __('pages.teacher') }}
                                            </label>
                                            <div class="col-lg-8 col-md-8 col-sm-12">
                                                <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                                    <select name="teacherId" id="teacherId" class="form-control">
                                                        @foreach($teachers as $teacher)
                                                            <option value="{{ $teacher->id }}" @if($teacher->id == $scheduleTeacherId) selected @endif>
                                                                {{ $teacher->surname }} {{ $teacher->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-4 col-md-4 col-sm-12 text-right" for="date">
                                                {{ __('pages.date') }}
                                            </label>
                                            <div class="col-lg-8 col-md-8 col-sm-12">
                                                <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                                    <input class="form-control" type="date" value="{{ $date }}" name="date" id="date">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="kt-pricing-1__items row mb-4">
                                <div class="col-lg-12 col-xl-12 text-center">
                                    <a href="{{ route('index') }}" class="btn btn-danger btn-bold">{{ __('pages.cancel') }}</a>
                                    <button type="submit" class="btn btn-primary btn-bold">
                                        {{ __('pages.get-teacher-time-btm') }}
                                    </button>
                                </div>
                            </div>
                            <div class="kt-pricing-1__items row">
                                <div class="col-lg-12">
                                    <div class="alert alert-secondary" role="alert">
                                        <div class="alert-icon"><i class="flaticon-questions-circular-button"></i></div>
                                        <div class="alert-text">
                                            <h5 >{{ __('pages.teacher-schedule') }}:</h5>
                                            <div class="row">
                                                @foreach($teacherSchedule as $day)
                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <span>{{ $day->dayName }}: </span>
                                                        @foreach($day->times as $key => $time)
                                                            <span>
                                                                @if($key > 0) ;&nbsp; @endif
                                                                {{ $time->refactoredTimeFrom }} - {{ $time->refactoredTimeTo }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="kt-pricing-1__items row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    @if($customErrors->count() > 0)
                                        @foreach($customErrors as $error)
                                            <div class="alert alert-danger fade show" role="alert">
                                                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                                <div class="alert-text">{{ $error }}</div>
                                                <div class="alert-close">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true"><i class="la la-close"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                    <div class="form-group form-group-last">
                                        <div class="alert alert-outline-primary fade show" role="alert">
                                            <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                            <div class="alert-text">
                                                {!! __('pages.schedule-time-description', ['tel' => \App\Config::instance()->getManagerPhoneNumber()]) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-6">
                        <form method="POST" action="{{ route('schedule.make_lesson') }}">
                            @csrf
                            <input type="hidden" name="date" value="{{ $date }}">
                            <input type="hidden" name="teacherId" value="{{ $scheduleTeacherId }}">
                            @if($errors->any())
                                <div class="kt-pricing-1__items row">
                                    @foreach($errors->all() as $error)
                                        <div class="col-lg-12">
                                            <div class="alert alert-outline-danger fade show" role="alert">
                                                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                                <div class="alert-text">{{ $error }}</div>
                                                <div class="alert-close">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true"><i class="la la-close"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            @if(session('success'))
                                <div class="kt-pricing-1__items row">
                                    <div class="col-lg-12">
                                        <div class="alert alert-outline-success fade show" role="alert">
                                            <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                            <div class="alert-text">{{ session('success') }}</div>
                                            <div class="alert-close">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true"><i class="la la-close"></i></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="kt-pricing-1__items row">
                                <div class="col-lg-12 col-xl-12">
                                    @php
                                        $teacher = $teachers->where('id', '=', $scheduleTeacherId)->first();
                                        $teacherFio = !is_null($teacher) ? $teacher->surname . ' ' . $teacher->name : '';
                                    @endphp
                                    @if(is_null($date))
                                        <div class="alert alert-warning fade show" role="alert">
                                            <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                            <div class="alert-text">
                                                {{ __('pages.error-date-empty') }}
                                            </div>
                                            <div class="alert-close">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true"><i class="la la-close"></i></span>
                                                </button>
                                            </div>
                                        </div>
                                    @elseif(count($teacherNearestTime) == 0)
                                        <div class="alert alert-warning fade show" role="alert">
                                            <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                            <div class="alert-text">
                                                {{ __('pages.teacher-nearest-time-empty', ['date' => date('d.m.Y', strtotime($date)), 'teacher' => $teacherFio]) }}
                                            </div>
                                            <div class="alert-close">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true"><i class="la la-close"></i></span>
                                                </button>
                                            </div>
                                        </div>
                                    @else
                                        <div class="kt-pricing-1__items row">
                                            @foreach($teacherNearestTime as $time)
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <label class="kt-option">
                                                        <span class="kt-option__control">
                                                            <span class="kt-radio kt-radio--bold kt-radio--brand" checked="">
                                                                <input type="radio" name="time" value="{{ json_encode($time) }}">
                                                                <span></span>
                                                            </span>
                                                        </span>
                                                        <span class="kt-option__label">
                                                            <span class="kt-option__head">
                                                                <span class="kt-option__title">
                                                                    {{ $teacherFio }}
                                                                </span>
                                                                <span class="kt-option__focus">
                                                                    {{ $time->refactoredTimeFrom }} - {{ $time->refactoredTimeTo }}
                                                                </span>
                                                            </span>
                                                            <span class="kt-option__body">
                                                                {{ $time->area }}, {{ date('d.m.Y', strtotime($date)) }}; &nbsp
                                                                {{ __('pages.class') }}: "{{ $time->class }}"
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @if(count($teacherNearestTime) > 0)
                                <div class="kt-pricing-1__items row">
                                    <div class="col-lg-12 col-xl-12 text-center">
                                        <button type="submit" class="btn btn-primary btn-bold">
                                            {{ __('pages.submit-lesson-btn') }}
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
