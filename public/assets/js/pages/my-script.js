const alert = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger'
    },
    buttonsStyling: false
});

var tablePageSizes = [5, 10, 20, 30, 50, 100];

$(function() {
    //Таблица истории платежей
    if ($('#kt_datatable_payments_history').length != 0) {
        $('#kt_datatable_payments_history').KTDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: '/api/payments',
                        method: 'get',
                        params: {
                            token: $('meta[name=token]').attr('content')
                        }
                    },
                },
                perPage: 5,
                pageSize: 5,
                serverPaging: true,
                serverFiltering: true,
                serverSorting: true,
            },
            translate: {
                records: {
                    noRecords: lang.get('no_payments')
                }
            },
            toolbar: {
                items: {
                    pagination: {
                        pageSizeSelect: tablePageSizes
                    }
                }
            },
            saveState: {
                cookie: false,
                webstorage: false
            },
            layout: {
                scroll: false,
                height: 'auto',
                footer: false
            },
            sortable: true,
            filterable: false,
            pagination: true,
            columns: [{
                field: "datetime",
                title: lang.get('date'),
                width: 55,
                sortable: true,
                autoHide: false,
                template: function(data) {
                    return '<span>'+data.refactored_date+'</span>';
                }
            }, {
                field: "type",
                title: lang.get('type'),
                width: 100,
                autoHide: false,
                sortable: true,
                className: 'dt-center',
                template: function(data, i) {
                    let statusClass = '';
                    switch (data.type) {
                        case '1': statusClass = 'btn-label-success';    break;
                        case '2': statusClass = 'btn-label-danger';     break;
                        default:  statusClass = 'btn-label-warning';    break;
                    }
                    return '<span class="btn btn-bold btn-sm btn-font-sm '+statusClass+'">'+lang.get('payment_type_' + data.type)+'</span>';
                }
            }, {
                field: "status",
                title: lang.get('status'),
                width: 'auto',
                autoHide: false,
                sortable: true,
                className: 'dt-center',
                template: function(data, i) {
                    let statusClass = '';
                    switch (data.status) {
                        case '1': statusClass = 'btn-label-success';    break;
                        case '2': statusClass = 'btn-label-danger';     break;
                        default:  statusClass = 'btn-label-warning';    break;
                    }
                    return '<span class="btn btn-bold btn-sm btn-font-sm '+statusClass+'">'+lang.get('payment_status_' + data.status)+'</span>';
                }
            }, {
                field: "value",
                title: lang.get('amount'),
                width: 60,
                sortable: true,
                className: 'dt-center',
                template: function(data) {
                    return '<span>'+data.value+' <i class="fa fa-ruble-sign"></i></span>';
                }
            }, {
                field: "description",
                title: lang.get('note'),
                width: 'auto',
                sortable: false,
                type: 'string',
                className: 'dt-center',
                template: function (data) {
                    return '<span>' + data.description + '</span>';
                }
            }]
        });
    }

    if ($('#kt_datatable_schedule_history').length != 0) {
        $('#kt_datatable_schedule_history').KTDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: '/api/reports',
                        method: 'get',
                        params: {
                            token: $('meta[name=token]').attr('content')
                        }
                    },
                },
                perPage: 5,
                pageSize: 5,
                serverPaging: true,
                serverFiltering: true,
                serverSorting: true,
            },
            translate: {
                records: {
                    noRecords: lang.get('no_reports')
                }
            },
            saveState: {
                cookie: false,
                webstorage: false
            },
            search: {
                onEnter: true,
                input: $('#schedule_kt_dashboard_daterangepicker_val'),
            },
            toolbar: {
                items: {
                    pagination: {
                        pageSizeSelect: tablePageSizes
                    }
                }
            },
            layout: {
                scroll: false,
                height: 'auto',
                footer: false
            },
            sortable: true,
            filterable: false,
            pagination: true,
            columns: [{
                field: "date",
                title: lang.get('date'),
                width: 60,
                sortable: true,
                type: 'string',
                autoHide: false,
                template: function(data) {
                    return '<span>'+data.refactored_date+'</span>';
                }
            }, {
                field: "time",
                title: lang.get('time'),
                width: 80,
                sortable: false,
                type: 'string',
                autoHide: false,
                template: function(data) {
                    return '<span>'+data.lesson_time_from+' - '+data.lesson_time_to+'</span>';
                }
            }, {
                field: "attendance",
                title: lang.get('status'),
                width: 'auto',
                autoHide: false,
                sortable: false,
                className: 'dt-center',
                template: function(data, i) {
                    let statusClass = '';
                    switch (data.attendance) {
                        case '1': statusClass = 'btn-label-success';    break;
                        case '0': statusClass = 'btn-label-danger';     break;
                        default:  statusClass = 'btn-label-warning';    break;
                    }
                    return '<span class="btn btn-bold btn-sm btn-font-sm '+statusClass+'">'+lang.get('report_attendance_' + data.attendance)+'</span>';
                }
            }, {
                field: "teacher_id",
                title: lang.get('teacher'),
                width: 'auto',
                sortable: true,
                type: 'string',
                className: 'dt-center',
                template: function(data) {
                    return '<span>'+data.teacher_fio+'</span>';
                }
            }]
        });
    }

    //Таблица расписания
    if ($('#kt_datatable_schedule').length != 0) {
        $('#kt_datatable_schedule').KTDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: '/api/schedule',
                        method: 'get',
                        params: {
                            token: $('meta[name=token]').attr('content')
                        }
                    },
                },
                perPage: 10,
                pageSize: 10,
                serverPaging: false,
                serverFiltering: true,
                serverSorting: false,
            },
            translate: {
                records: {
                    noRecords: lang.get('no_lessons')
                }
            },
            saveState: {
                cookie: false,
                webstorage: false
            },
            toolbar: {
                items: {
                    pagination: {
                        pageSizeSelect: tablePageSizes
                    }
                }
            },
            layout: {
                scroll: false,
                height: 'auto',
                footer: false
            },
            sortable: true,
            filterable: false,
            pagination: false,
            columns: [{
                field: "date",
                title: lang.get('date'),
                width: 100,
                sortable: false,
                //type: 'string',
                class: 'dt-center',
                autoHide: false,
                template: function(data) {
                    return '<span>'+data.refactored_date+'</span>';
                }
            }, {
                field: "area_id",
                title: lang.get('area'),
                sortable: false,
                width: 150,
                //type: 'string',
                class: 'dt-center',
                autoHide: true,
                template: function(data) {
                    let output = '';
                    $.each(data.lessons, function(key, lesson) {
                        output += '<p>'+ lesson.area +'</p>';
                    });
                    return output;
                }
            }, {
                field: "teacher_id",
                title: lang.get('teacher'),
                width: 200,
                sortable: false,
                //type: 'string',
                //class: 'dt-center',
                autoHide: true,
                template: function(data) {
                    let output = '';
                    $.each(data.lessons, function(key, lesson) {
                        output += '<p>'+ lesson.teacher +'</p>';
                    });
                    return output;
                }
            }, {
                field: "time",
                title: lang.get('time'),
                width: 150,
                sortable: true,
                type: 'string',
                class: 'dt-right',
                autoHide: true,
                template: function(data) {
                    let output = '<div style="width: 100%; text-align: right; margin-right: 25px">';
                    $.each(data.lessons, function(key, lesson) {
                        output += ''+lesson.refactored_time_from + ' ' + lesson.refactored_time_to + '';
                        output += '<div class="dropdown" style="display: inline-block">' +
                                        '<a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md" aria-expanded="false">' +
                                            '<i class="la la-cog"></i>' +
                                        '</a>' +
                                    '<div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="display: none; position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(1474px, 531px, 0px);">' +
                                        '<a href="#" class="dropdown-item lessonCancel" data-lesson="'+lesson.id+'" data-date="'+data.date+'">' +
                                            '<i class="flaticon-circle"></i> '+lang.get('cancel')+
                                        '</a>' +
                                    '</div>' +
                                '</div>';
                        output += '<br>';
                    });
                    output += '</div>';
                    return output;
                }
            }]
        });
    }

    //Указатель периода для занятий
    let $scheduleRangePicker = $('#schedule_kt_dashboard_daterangepicker');
    if ($scheduleRangePicker.length !== 0) {
        let
            $scheduleTable = $('#kt_datatable_schedule'),
            format = 'DD.MM.YYYY',
            start = moment(),
            end = moment().add(6, 'days');

        function cb(start, end, label) {
            var title = '';
            var range = '';

            if (label !== lang.get('daterangepicker_customRangeLabel')) {
                if (label === '') {
                    label = lang.get('week');
                }
                title = label;
                range = start.format(format) + ' - ' + end.format(format);
            }

            $('#schedule_kt_dashboard_daterangepicker_title').html(range);
            $('#schedule_kt_dashboard_daterangepicker_date').html(title);
            if (label !== '') {
                $scheduleTable.KTDatatable().spinnerCallback(true);
                $scheduleTable.KTDatatable().search(range, 'date');
            }
        }

        let ranges = {};
        //ranges[lang.get('today')] = [moment(), moment()];
        //ranges[lang.get('tomorrow')] = [moment().add(1, 'days'), moment().add(1, 'days')];
        ranges[lang.get('last_7_days')] = [moment(), moment().add(6, 'days')];
        ranges[lang.get('last_30_days')] = [moment(), moment().add(29, 'days')];
        ranges[lang.get('this_month')] = [moment().startOf('month'), moment().endOf('month')];
        //ranges[lang.get('next_month')] = [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')];
        ranges[lang.get('next_month')] = [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')];

        let locales = {
            "format": lang.get('daterangepicker_format'),
            "separator": lang.get('daterangepicker_separator'),
            "applyLabel": lang.get('daterangepicker_applyLabel'),
            "cancelLabel": lang.get('daterangepicker_cancelLabel'),
            "fromLabel": lang.get('daterangepicker_fromLabel'),
            "toLabel": lang.get('daterangepicker_toLabel'),
            "customRangeLabel": lang.get('daterangepicker_customRangeLabel'),
            "daysOfWeek": [
                lang.get('daterangepicker_day_sunday'),
                lang.get('daterangepicker_day_monday'),
                lang.get('daterangepicker_day_tuesday'),
                lang.get('daterangepicker_day_wednesday'),
                lang.get('daterangepicker_day_thursday'),
                lang.get('daterangepicker_day_friday'),
                lang.get('daterangepicker_day_saturday'),
            ],
            "monthNames": [
                lang.get('daterangepicker_month_january'),
                lang.get('daterangepicker_month_february'),
                lang.get('daterangepicker_month_march'),
                lang.get('daterangepicker_month_april'),
                lang.get('daterangepicker_month_may'),
                lang.get('daterangepicker_month_june'),
                lang.get('daterangepicker_month_july'),
                lang.get('daterangepicker_month_august'),
                lang.get('daterangepicker_month_september'),
                lang.get('daterangepicker_month_october'),
                lang.get('daterangepicker_month_november'),
                lang.get('daterangepicker_month_december'),
            ],
            "firstDay": 1
        };

        $scheduleRangePicker.daterangepicker({
            direction: KTUtil.isRTL(),
            startDate: start,
            endDate: end,
            opens: 'left',
            ranges: ranges,
            locale: locales
        }, cb);

        cb(start, end, '');
    }

    if ($('#kt_datatable_rates').length != 0) {
        $('#kt_datatable_rates').KTDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: '/api/rates',
                        method: 'get',
                        params: {
                            token: $('meta[name=token]').attr('content')
                        }
                    },
                },
                perPage: 5,
                pageSize: 5,
                serverPaging: true,
                serverFiltering: false,
                serverSorting: false,
            },
            translate: {
                records: {
                    noRecords: lang.get('no_rates')
                }
            },
            saveState: {
                cookie: false,
                webstorage: false
            },
            toolbar: {
                items: {
                    pagination: {
                        pageSizeSelect: tablePageSizes
                    }
                }
            },
            layout: {
                scroll: false,
                height: 'auto',
                footer: false
            },
            sortable: true,
            filterable: false,
            pagination: false,
            columns: [{
                field: "title",
                title: lang.get('title'),
                width: 'auto',
                sortable: true,
                type: 'string',
                autoHide: false,
                template: function(data) {
                    return '<span>'+data.title+'</span>';
                }
            }, {
                field: "countIndiv",
                title: lang.get('count_indiv'),
                width: 'auto',
                sortable: true,
                type: 'number',
                className: 'dt-center',
                template: function(data) {
                    return '<span>'+data.countIndiv+'</span>';
                }
            }, {
                field: "countGroup",
                title: lang.get('count_group'),
                width: 'auto',
                sortable: true,
                type: 'number',
                className: 'dt-center',
                template: function(data) {
                    return '<span>'+data.countGroup+'</span>';
                }
            }, {
                field: "price",
                title: lang.get('price'),
                width: 'auto',
                autoHide: false,
                sortable: true,
                type: 'number',
                className: 'dt-center',
                template: function(data, i) {
                    return '<span class="kt-align-right kt-font-brand kt-font-bold">'+data.price+' <i class="fa fa-ruble-sign"></i></span>';
                }
            }, {
                field: "actions",
                title: '',
                width: 'auto',
                autoHide: false,
                sortable: false,
                className: 'dt-center',
                template: function(data, i) {
                    return '<a href="/rates/buy/'+data.id+'" class="btn btn-success">'+lang.get('buy')+'</a>';
                }
            }]
        });
    }

    if ($('#kt_datatable_absent_periods').length != 0) {
        $('#kt_datatable_absent_periods').KTDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: '/api/schedule/absents/list',
                        method: 'get',
                        params: {
                            token: $('meta[name=token]').attr('content')
                        }
                    },
                },
                perPage: 5,
                pageSize: 5,
                serverPaging: true,
                serverFiltering: false,
                serverSorting: false,
            },
            translate: {
                records: {
                    noRecords: lang.get('no_periods')
                }
            },
            saveState: {
                cookie: false,
                webstorage: false
            },
            toolbar: {
                items: {
                    pagination: {
                        pageSizeSelect: tablePageSizes
                    }
                }
            },
            layout: {
                scroll: false,
                height: 'auto',
                footer: false
            },
            sortable: true,
            filterable: false,
            pagination: false,
            columns: [{
                field: "date_from",
                title: lang.get('date_from'),
                width: 70,
                sortable: true,
                type: 'string',
                autoHide: false,
                template: function(data) {
                    return '<span>'+data.refactored_date_from+'</span>';
                }
            }, {
                field: "date_to",
                title: lang.get('date_to'),
                width: 70,
                sortable: true,
                type: 'number',
                className: 'dt-center',
                template: function(data) {
                    return '<span>'+data.refactored_date_to+'</span>';
                }
            }, {
                field: "actions",
                title: '',
                width: 30,
                autoHide: false,
                sortable: false,
                className: 'dt-center',
                template: function(data, i) {
                    return '<div style="width: 100%; text-align: right; margin-right: 25px">' +
                                '<div class="dropdown" style="display: inline-block">' +
                                    '<a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md" aria-expanded="false">' +
                                        '<i class="la la-cog"></i>' +
                                    '</a>' +
                                    '<div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="display: none; position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(1474px, 531px, 0px);">' +
                                        '<a href="#" class="dropdown-item absentPeriodDelete" data-id="'+data.id+'">' +
                                            '<i class="flaticon2-trash"></i> '+lang.get('cancel')+
                                        '</a>' +
                                    '</div>' +
                                '</div>' +
                            '</div>';
                }
            }]
        });
    }

    if ($('#absentPeriodForm').length !== 0) {
        initAjaxForm('#absentPeriodForm', function (response) {
            ajaxFormSuccessCallbackDefault(response);
            $('#absentPeriodModal').modal('hide');
            $('#kt_datatable_absent_periods').KTDatatable().reload();
            $('#kt_datatable_schedule').KTDatatable().reload();
        });
    }

    $(document)
        .on('click', '.lessonCancel', function(e) {
            e.preventDefault();
            let lessonId = $(this).data('lesson');
            let date = $(this).data('date');
            alert.fire({
                title: lang.get('lesson_cancel_alert'),
                //text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: lang.get('yes'),
                cancelButtonText: lang.get('no'),
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: '/schedule/lesson-absent',
                        dataType: 'json',
                        data: {
                            _token: $('meta[name=csrf_token]').attr('content'),
                            token: $('meta[name=token]').attr('content'),
                            lesson_id: lessonId,
                            date: date
                        },
                        success: function(response) {
                            alert.fire({
                                type: response.status,
                                title: response.message
                            });
                            $('#kt_datatable_schedule').KTDatatable().reload();
                        }
                    });
                }
            });
        })
        .on('click', '.absentPeriodDelete', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            alert.fire({
                title: lang.get('absent_period_delete_alert'),
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: lang.get('yes'),
                cancelButtonText: lang.get('no'),
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: '/api/schedule/absents/delete',
                        dataType: 'json',
                        data: {
                            _token: $('meta[name=csrf_token]').attr('content'),
                            token: $('meta[name=token]').attr('content'),
                            id: id
                        },
                        success: function(response) {
                            alert.fire({
                                type: response.status,
                                title: response.message
                            });
                            $('#kt_datatable_absent_periods').KTDatatable().reload();
                        }
                    });
                }
            });
        });
});
