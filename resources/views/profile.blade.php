@extends('layouts.app', ['page' => 'profile', 'disableNotifications' => true])

@section('content')
    <div class="kt-portlet kt-portlet--tabs">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-toolbar">
                <ul class="nav nav-tabs nav-tabs-space-xl nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#kt_user_edit_tab_1" role="tab">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon points="0 0 24 0 24 24 0 24" />
                                    <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                    <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
                                </g>
                            </svg> {{ __('profile.title') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="tab-content">
                <div class="tab-pane active" id="kt_user_edit_tab_1" role="tabpanel">
                    <div class="kt-form kt-form--label-right">
                        <form action="{{ route('profile.save', $user->group) }}" method="POST">
                            @csrf
                            <div class="kt-form__body">
                                <div class="kt-section kt-section--first">
                                    <div class="kt-section__body">
                                        <div class="row">
                                            <label class="col-xl-3"></label>
                                            <div class="col-lg-9 col-xl-6">
                                                <h3 class="kt-section__title kt-section__title-sm">
                                                    {{ __('profile.tab_account') }}
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label" for="first-name">
                                                {{ __('profile.first_name') }}
                                            </label>
                                            <div class="col-lg-9 col-xl-6">
                                                <input class="form-control @error('surname') is-invalid @enderror" type="text" name="surname" id="first-name" value="{{ $user->surname ?? '' }}">
                                                @error('surname')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label" for="last-name">
                                                {{ __('profile.last_name') }}
                                            </label>
                                            <div class="col-lg-9 col-xl-6">
                                                <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="last-name" value="{{ $user->name ?? '' }}">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label" for="phone_number">
                                                {{ __('profile.phone_number') }}
                                            </label>
                                            <div class="col-lg-9 col-xl-6">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="la la-phone"></i></span></div>
                                                    <input type="text" class="form-control masked-phone @error('phone_number') is-invalid @enderror" name="phone_number" id="phone_number" value="{{ $user->phone_number ?? '' }}" placeholder="{{ __('profile.phone_number') }}" aria-describedby="basic-addon1">
                                                    @error('phone_number')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label" for="login">
                                                {{ __('profile.login') }}
                                            </label>
                                            <div class="col-lg-9 col-xl-6">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="login" id="login" value="{{ $user->login ?? '' }}" placeholder="{{ __('profile.login') }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label" for="email">
                                                {{ __('profile.email') }}
                                            </label>
                                            <div class="col-lg-9 col-xl-6">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="la la-at"></i></span></div>
                                                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ $user->email ?? '' }}" placeholder="{{ __('profile.email') }}" aria-describedby="basic-addon1">
                                                    @error('email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <span class="form-text text-muted">{{ __('profile.email_description') }}</span>
                                            </div>
                                        </div>

                                        <div class="kt-separator kt-separator--border-dashed kt-separator--portlet-fit kt-separator--space-lg"></div>

                                        <div class="row">
                                            <label class="col-xl-3"></label>
                                            <div class="col-lg-9 col-xl-6">
                                                <h3 class="kt-section__title kt-section__title-sm">
                                                    {{ __('profile.tab_change_password') }}
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label" for="password_old">
                                                {{ __('profile.old_password') }}
                                            </label>
                                            <div class="col-lg-9 col-xl-6">
                                                <input type="password" class="form-control @error('password_old') is-invalid @enderror" name="password_old" id="password_old" placeholder="{{ __('profile.old_password') }}">
                                                @error('password_old')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label" for="password">
                                                {{ __('profile.new_password') }}
                                            </label>
                                            <div class="col-lg-9 col-xl-6">
                                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="{{ __('profile.new_password') }}">
                                            </div>
                                        </div>
                                        <div class="form-group form-group-last row">
                                            <label class="col-xl-3 col-lg-3 col-form-label" for="password_confirmation">
                                                {{ __('profile.confirm_password') }}
                                            </label>
                                            <div class="col-lg-9 col-xl-6">
                                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" id="password_confirmation" placeholder="{{ __('profile.confirm_password') }}">
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="kt-separator kt-separator--space-lg kt-separator--fit kt-separator--border-solid"></div>
                            <div class="kt-form__actions text-right">
                                <a href="{{ route('index') }}" class="btn btn-label-danger btn-bold">{{ __('pages.cancel') }}</a>
                                <button type="submit" class="btn btn-label-success btn-bold">{{ __('pages.save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

