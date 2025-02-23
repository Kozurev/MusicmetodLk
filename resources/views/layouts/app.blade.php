<!DOCTYPE html>
<html lang="en">

<!-- begin::Head -->
<head>
    <base href="">
    <meta charset="utf-8" />
    <title>{{ __('pages.' . $page ?? '') }} | {{ config('app.name') }}</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf_token" content="{{ csrf_token() }}">

    @if(\App\User::isAuth())
        <meta name="token" content="{{ \App\User::getToken() }}">
    @endif

    <!--begin::Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Asap+Condensed:500">

    <!--end::Fonts -->

    <!--begin::Page Vendors Styles(used by this page) -->
    <link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />

    <!--end::Page Vendors Styles -->

    <!--begin::Global Theme Styles(used by all pages) -->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/pages/support-center/faq-3.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/custom/toastr/toastr.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/custom/swal/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css" />

    <!--end::Global Theme Styles -->

    <!--begin::Layout Skins(used by all pages) -->

    <!--end::Layout Skins -->
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />
</head>

<!-- end::Head -->

<!-- begin::Body -->
<body class="kt-page-content-white kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-aside--enabled kt-aside--fixed kt-page--loading">
<!-- begin:: Page -->

<!-- begin:: Header Mobile -->
<div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
    <div class="kt-header-mobile__logo">
        <a href="{{ route('index') }}">
            <img alt="Logo" src="{{ asset('assets/media/logos/logo-11-sm.png') }}" />
        </a>
    </div>
    <div class="kt-header-mobile__toolbar">
        <button class="kt-header-mobile__toolbar-toggler kt-header-mobile__toolbar-toggler--left" id="kt_aside_mobile_toggler"><span></span></button>
        <button class="kt-header-mobile__toolbar-topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more-1"></i></button>
    </div>
</div>

<!-- end:: Header Mobile -->
<div class="kt-grid kt-grid--hor kt-grid--root">
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
            <div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed " data-ktheader-minimize="on">
                <div class="kt-container  kt-container--fluid ">

                    <div class="kt-header__brand " id="kt_header_brand">
                        <div class="kt-header__brand-logo">
                            <a href="{{ route('index') }}">
                                <img alt="Logo" src="{{ asset('assets/media/logos/logo-11.png') }}" />
                            </a>
                        </div>
                    </div>

                    <div class="kt-header__topbar">
                        <div class="kt-header__topbar-item kt-header__topbar-item--user">
                            <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
                                <span class="kt-header__topbar-welcome kt-visible-desktop kt-visible-mobile">
                                    {{ $user->surname }} {{ $user->name }}
                                    @if (isset($user->balance))
                                        <b>
                                            {{ \App\Format::amount($user->balance->amount) ?? 0.00 }}
                                            <i class="fa fa-ruble-sign"></i>
                                        </b>
                                    @endif
                                </span>
                            </div>
                            <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">
                                <!--begin: Navigation -->
                                <div class="kt-notification">
                                    <a href="{{ route('profile.edit', $user->group) }}" class="kt-notification__item">
                                        <div class="kt-notification__item-icon">
                                            <i class="flaticon2-calendar-3 kt-font-success"></i>
                                        </div>
                                        <div class="kt-notification__item-details">
                                            <div class="kt-notification__item-title kt-font-bold">
                                                {{ __('profile.title') }}
                                            </div>
                                            <div class="kt-notification__item-time">
                                                {{ __('profile.subtitle') }}
                                            </div>
                                        </div>
                                    </a>
                                    <div class="kt-notification__custom kt-space-between text-right">
                                        <a href="{{ route('login.logout') }}" class="btn btn-label btn-label-brand btn-sm btn-bold">
                                            {{ __('login.sign-out-btn') }}
                                        </a>
                                    </div>
                                </div>
                                <!--end: Navigation -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
                <div class="kt-container  kt-container--fluid  kt-grid kt-grid--ver">
                    <button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>
                    <div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop" id="kt_aside">
                        @include('layouts.nav.'.\App\User::getRoleTag().'.nav')
                    </div>
                    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
                        <div class="kt-subheader   kt-grid__item" id="kt_subheader">
                        </div>
                        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                            @include('layouts.notifications')
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>

            <!-- begin:: Footer -->
            <div class="kt-footer kt-grid__item" id="kt_footer">
                <div class="kt-container  kt-container--fluid ">
                    <div class="kt-footer__wrapper">
                        <div class="kt-footer__copyright">
                            {{ date('Y') }}&nbsp;&copy;&nbsp;<a href="{{ config('app.official_site') }}" target="_blank" class="kt-link">
                                {{ config('app.name') }}
                            </a>
                        </div>
                        <div class="kt-footer__menu">
                            <a href="{{ config('app.official_site') }}" target="_blank" class="kt-link">
                                {{ __('login.official-site') }}
                            </a>
                            <a href="{{ config('app.policy_link') }}" target="_blank" class="kt-link">
                                {{ __('login.policy') }}
                            </a>
                            <a href="{{ config('app.oferta_link') }}" target="_blank" class="kt-link">
                                {{ __('login.oferta') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end:: Footer -->
        </div>
    </div>
</div>

<!-- end:: Page -->

<!-- begin::Scrolltop -->
<div id="kt_scrolltop" class="kt-scrolltop">
    <i class="fa fa-arrow-up"></i>
</div>
<!-- end::Scrolltop -->

@yield('modals')

<!-- begin::Global Config(global config for global JS sciprts) -->
<script>
    var KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#5d78ff",
                "light": "#ffffff",
                "dark": "#282a3c",
                "primary": "#5867dd",
                "success": "#34bfa3",
                "info": "#36a3f7",
                "warning": "#ffb822",
                "danger": "#fd3995"
            },
            "base": {
                "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
                "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
            }
        }
    };
</script>

<!-- end::Global Config -->

<!--begin::Global Theme Bundle(used by all pages) -->
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/jquery.maskedinput/src/jquery.maskedinput.js') }}" type="text/javascript"></script>

<!--end::Global Theme Bundle -->

<!--begin::Page Vendors(used by this page) -->
<script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/custom/gmaps/gmaps.js') }}" type="text/javascript"></script>
{{--<script src="{{ asset('assets/plugins/custom/toastr/toastr.js') }}" type="text/javascript"></script>--}}
{{--<script src="{{ asset('assets/plugins/custom/swal/sweetalert.min.js') }}" type="text/javascript"></script>--}}

<!--end::Page Vendors -->

<!--begin::Page Scripts(used by this page) -->
<script src="{{ asset('assets/js/pages/dashboard.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/pages/lang.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/form.js') }}" type="text/javascript"></script>

@if(\Request::route()->getName() == 'faq.index' && !empty(\App\Config::instance()->getJivoLink()))
    <script src="{{ \App\Config::instance()->getJivoLink() }}"></script>
@endif

<script>
    var locales = {
        area: '{{ __('pages.area') }}',
        date: '{{ __('pages.date') }}',
        time: '{{ __('pages.time') }}',
        amount: '{{ __('pages.amount') }}',
        note: '{{ __('pages.note') }}',
        type: '{{ __('pages.type') }}',
        teacher: '{{ __('pages.teacher') }}',
        status: '{{ __('pages.status') }}',
        cancel: '{{ __('pages.cancel') }}',
        yes: '{{ __('pages.yes') }}',
        no: '{{ __('pages.no') }}',
        actions: '{{ __('pages.actions') }}',
        date_from: '{{ __('pages.date_from') }}',
        date_to: '{{ __('pages.date_to') }}',
        lesson_cancel_alert: '{{ __('pages.lesson-cancel-alert') }}',
        no_payments: '{{ __('pages.no-payments') }}',
        no_reports: '{{ __('pages.no-reports') }}',
        no_lessons: '{{ __('pages.no-lessons') }}',
        no_rates: '{{ __('pages.no-rates') }}',
        no_periods: '{{ __('pages.no-periods') }}',
        payment_type_1: '{{ \App\Api\Payment::getTypeName(1) }}',
        payment_type_2: '{{ \App\Api\Payment::getTypeName(2) }}',
        payment_type_3: '{{ \App\Api\Payment::getTypeName(3) }}',
        payment_type_15: '{{ \App\Api\Payment::getTypeName(15) }}',
        payment_type_21: '{{ \App\Api\Payment::getTypeName(21) }}',
        payment_type_23: '{{ \App\Api\Payment::getTypeName(23) }}',
        payment_status_0: '{{ \App\Api\Payment::getStatusName(0) }}',
        payment_status_1: '{{ \App\Api\Payment::getStatusName(1) }}',
        payment_status_2: '{{ \App\Api\Payment::getStatusName(2) }}',
        report_attendance_0: '{{ __('api.report-attendance-0') }}',
        report_attendance_1: '{{ __('api.report-attendance-1') }}',

        title: '{{ __('pages.title') }}',
        count_indiv: '{{ __('pages.count-indiv') }}',
        count_group: '{{ __('pages.count-group') }}',
        price: '{{ __('pages.price') }}',
        buy: '{{ __('pages.buy') }}',
        buy_credit: '{{ __('pages.buy-credit') }}',

        today: '{{ __('daterange.today') }}',
        yesterday: '{{ __('daterange.yesterday') }}',
        tomorrow: '{{ __('daterange.tomorrow') }}',
        last_7_days: '{{ __('daterange.last_7_days') }}',
        last_30_days: '{{ __('daterange.last_30_days') }}',
        this_month: '{{ __('daterange.this_month') }}',
        last_month: '{{ __('daterange.last_month') }}',
        next_month: '{{ __('daterange.next_month') }}',

        daterangepicker_format: '{{ __('daterange.format') }}',
        daterangepicker_separator: '{{ __('daterange.separator') }}',
        daterangepicker_applyLabel: '{{ __('daterange.applyLabel') }}',
        daterangepicker_cancelLabel: '{{ __('daterange.cancelLabel') }}',
        daterangepicker_fromLabel: '{{ __('daterange.fromLabel') }}',
        daterangepicker_toLabel: '{{ __('daterange.toLabel') }}',
        daterangepicker_customRangeLabel: '{{ __('daterange.customRangeLabel') }}',

        daterangepicker_day_sunday_short: '{{ __('daterange.day-sunday-short') }}',
        daterangepicker_day_monday_short: '{{ __('daterange.day-monday-short') }}',
        daterangepicker_day_tuesday_short: '{{ __('daterange.day-tuesday-short') }}',
        daterangepicker_day_wednesday_short: '{{ __('daterange.day-wednesday-short') }}',
        daterangepicker_day_thursday_short: '{{ __('daterange.day-thursday-short') }}',
        daterangepicker_day_friday_short: '{{ __('daterange.day-friday-short') }}',
        daterangepicker_day_saturday_short: '{{ __('daterange.day-saturday-short') }}',

        daterangepicker_day_sunday: '{{ __('daterange.day-sunday') }}',
        daterangepicker_day_monday: '{{ __('daterange.day-monday') }}',
        daterangepicker_day_tuesday: '{{ __('daterange.day-tuesday') }}',
        daterangepicker_day_wednesday: '{{ __('daterange.day-wednesday') }}',
        daterangepicker_day_thursday: '{{ __('daterange.day-thursday') }}',
        daterangepicker_day_friday: '{{ __('daterange.day-friday') }}',
        daterangepicker_day_saturday: '{{ __('daterange.day-saturday') }}',

        daterangepicker_month_january: '{{ __('daterange.month-january') }}',
        daterangepicker_month_february: '{{ __('daterange.month-february') }}',
        daterangepicker_month_march: '{{ __('daterange.month-march') }}',
        daterangepicker_month_april: '{{ __('daterange.month-april') }}',
        daterangepicker_month_may: '{{ __('daterange.month-may') }}',
        daterangepicker_month_june: '{{ __('daterange.month-june') }}',
        daterangepicker_month_july: '{{ __('daterange.month-july') }}',
        daterangepicker_month_august: '{{ __('daterange.month-august') }}',
        daterangepicker_month_september: '{{ __('daterange.month-september') }}',
        daterangepicker_month_october: '{{ __('daterange.month-october') }}',
        daterangepicker_month_november: '{{ __('daterange.month-november') }}',
        daterangepicker_month_december: '{{ __('daterange.month-december') }}',

        absent_period_delete_alert: '{{ __('pages.absent-period-delete-alert') }}',
        absent_period_delete_success: '{{ __('pages.absent-period-delete-success') }}',

        make_lesson_report_alert: '{{ __('pages.make-lesson-report-alert') }}'
    };
    function lang(symbol) {
        return locales[symbol];
    }
</script>

<script>
    $.extend(true, $.fn.KTDatatable.defaults, {
        translate: {
            records: {
                processing: '{{ __('datatable.processing') }}',
                noRecords: '{{ __('datatable.noRecords') }}',
            },
            toolbar: {
                pagination: {
                    items: {
                        default: {
                            first: '{{ __('datatable.first') }}',
                            prev: '{{ __('datatable.prev') }}',
                            next: '{{ __('datatable.next') }}',
                            last: '{{ __('datatable.last') }}',
                            more: '{{ __('datatable.more') }}',
                            input: '{{ __('datatable.input') }}',
                            select: '{{ __('datatable.select') }}'
                        },
                        info: '{{ __('datatable.info') }}'
                    }
                }
            }
        }
    });

    $.fn.daterangepicker.defaultOptions = {
        locale: {
            "format": lang('daterangepicker_format'),
            "separator": lang('daterangepicker_separator'),
            "applyLabel": lang('daterangepicker_applyLabel'),
            "cancelLabel": lang('daterangepicker_cancelLabel'),
            "fromLabel": lang('daterangepicker_fromLabel'),
            "toLabel": lang('daterangepicker_toLabel'),
            "customRangeLabel": lang('daterangepicker_customRangeLabel'),
            "daysOfWeek": [
                lang('daterangepicker_day_sunday_short'),
                lang('daterangepicker_day_monday_short'),
                lang('daterangepicker_day_tuesday_short'),
                lang('daterangepicker_day_wednesday_short'),
                lang('daterangepicker_day_thursday_short'),
                lang('daterangepicker_day_friday_short'),
                lang('daterangepicker_day_saturday_short'),
            ],
            "monthNames": [
                lang('daterangepicker_month_january'),
                lang('daterangepicker_month_february'),
                lang('daterangepicker_month_march'),
                lang('daterangepicker_month_april'),
                lang('daterangepicker_month_may'),
                lang('daterangepicker_month_june'),
                lang('daterangepicker_month_july'),
                lang('daterangepicker_month_august'),
                lang('daterangepicker_month_september'),
                lang('daterangepicker_month_october'),
                lang('daterangepicker_month_november'),
                lang('daterangepicker_month_december')
            ],
            "firstDay": 1
        }
    };

    //DATE PICKERS
    var datePickerTemplate;
    if (KTUtil.isRTL()) {
        datePickerTemplate = {
            leftArrow: '<i class="la la-angle-right"></i>',
            rightArrow: '<i class="la la-angle-left"></i>'
        }
    } else {
        datePickerTemplate = {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        }
    }

    var datepickerLocales = {
        days: [
            lang('daterangepicker_day_sunday'),
            lang('daterangepicker_day_monday'),
            lang('daterangepicker_day_tuesday'),
            lang('daterangepicker_day_wednesday'),
            lang('daterangepicker_day_thursday'),
            lang('daterangepicker_day_friday'),
            lang('daterangepicker_day_saturday')
        ],
        daysShort: [
            lang('daterangepicker_day_sunday_short'),
            lang('daterangepicker_day_monday_short'),
            lang('daterangepicker_day_tuesday_short'),
            lang('daterangepicker_day_wednesday_short'),
            lang('daterangepicker_day_thursday_short'),
            lang('daterangepicker_day_friday_short'),
            lang('daterangepicker_day_saturday_short')
        ],
        daysMin: [
            lang('daterangepicker_day_sunday_short'),
            lang('daterangepicker_day_monday_short'),
            lang('daterangepicker_day_tuesday_short'),
            lang('daterangepicker_day_wednesday_short'),
            lang('daterangepicker_day_thursday_short'),
            lang('daterangepicker_day_friday_short'),
            lang('daterangepicker_day_saturday_short')
        ],
        months: [
            lang('daterangepicker_month_january'),
            lang('daterangepicker_month_february'),
            lang('daterangepicker_month_march'),
            lang('daterangepicker_month_april'),
            lang('daterangepicker_month_may'),
            lang('daterangepicker_month_june'),
            lang('daterangepicker_month_july'),
            lang('daterangepicker_month_august'),
            lang('daterangepicker_month_september'),
            lang('daterangepicker_month_october'),
            lang('daterangepicker_month_november'),
            lang('daterangepicker_month_december')
        ],
        monthsShort: [
            lang('daterangepicker_month_january'),
            lang('daterangepicker_month_february'),
            lang('daterangepicker_month_march'),
            lang('daterangepicker_month_april'),
            lang('daterangepicker_month_may'),
            lang('daterangepicker_month_june'),
            lang('daterangepicker_month_july'),
            lang('daterangepicker_month_august'),
            lang('daterangepicker_month_september'),
            lang('daterangepicker_month_october'),
            lang('daterangepicker_month_november'),
            lang('daterangepicker_month_december')
        ],
        today: lang('today'),
        clear: lang('cancel'),
        format: "mm.dd.yyyy",
        weekStart: 0
    };

    $.extend(true, $.fn.datepicker.defaults, {
        templates: datePickerTemplate,
        language: 'ru',
        locale: 'ru'
    });
    $.fn.datepicker.dates['ru'] = datepickerLocales;

</script>

<script src="{{ asset('assets/js/pages/my-script.js?' . time()) }}" type="text/javascript"></script>

<!--end::Page Scripts -->
</body>

<!-- end::Body -->
</html>
