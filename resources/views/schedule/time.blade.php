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

        <div class="kt-portlet__body">
            <div class="kt-pricing-1 kt-pricing-1--fixed">
                <div class="kt-pricing-1__items row">
                    <div class="col-lg-6">
                        <form method="GET" action="{{ route('schedule.find_teacher_time') }}">
                            @if($customErrors->count() == 0)
                                <div class="kt-pricing-1__items row">
                                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-6 col-md-6 col-sm-12 text-right" for="teacherId">
                                                {{ __('pages.teacher') }}
                                            </label>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
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
                                            <label class="col-form-label col-lg-6 col-md-6 col-sm-12 text-right" for="date">
                                                {{ __('pages.date') }}
                                            </label>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                                    <input class="form-control" type="date" value="{{ $date }}" name="date" id="date">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-8 col-sm-12">
                                        <h5 class="text-center">{{ __('pages.teacher-schedule') }}:</h5>
                                        <ul >
                                            @foreach($teacherSchedule as $day)
                                                <li>
                                                    <span>{{ $day->dayName }}: </span>
                                                    @foreach($day->times as $key => $time)
                                                        <span>
                                                        @if($key > 0) ;&nbsp; @endif
                                                            {{ $time->refactoredTimeFrom }} - {{ $time->refactoredTimeTo }}
                                                    </span>
                                                    @endforeach
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
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
                                        <div class="alert alert-secondary" role="alert">
                                            <div class="alert-icon"><i class="flaticon-questions-circular-button"></i></div>
                                            <div class="alert-text">
                                                {{ __('pages.schedule-time-description') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="kt-pricing-1__items row">
                                <div class="col-lg-12 col-xl-12">
                                    <button type="submit" class="btn btn-success btn-bold">
                                        {{ __('pages.get-teacher-time-btm') }}
                                    </button>
                                    <a href="{{ route('rates.index') }}" class="btn btn-danger btn-bold">{{ __('pages.cancel') }}</a>
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
                                            <div class="alert alert-danger fade show" role="alert">
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
                            <div class="kt-pricing-1__items row">
                                <div class="col-lg-12 col-xl-12">
                                    @php
                                        $teacher = $teachers->where('id', '=', $scheduleTeacherId)->first();
                                        $teacherFio = $teacher->surname . ' ' . $teacher->name;
                                    @endphp
                                    @if(count($teacherNearestTime) == 0)
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
                                                                <input type="radio" name="time" value="{{ $time->timeFrom }} - {{ $time->timeTo }}">
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
                                                                {{ date('d.m.Y', strtotime($date)) }}
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
                                    <div class="col-lg-12 col-xl-12">
                                        <button type="submit" class="btn btn-success btn-bold">
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
