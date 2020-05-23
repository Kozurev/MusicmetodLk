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
                        pageSizeSelect: [5, 10, 20, 30, 50, 100]
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
                width: 70,
                sortable: true,
                autoHide: false,
                template: function(data) {
                    return '<span>'+data.refactored_date+'</span>';
                }
            }, {
                field: "type",
                title: lang.get('type'),
                width: 90,
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
                        pageSizeSelect: [5, 10, 20, 30, 50, 100]
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
                field: "teacher_id",
                title: lang.get('teacher'),
                width: 'auto',
                sortable: true,
                type: 'string',
                className: 'dt-center',
                template: function(data) {
                    return '<span>'+data.teacher_fio+'</span>';
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
                        pageSizeSelect: [5, 10, 20, 30, 50, 100]
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
                width: 'auto',
                sortable: true,
                type: 'string',
                autoHide: false,
                template: function(data) {
                    return '<span>'+data.refactored_date+'</span>';
                }
            },{
                field: "area_id",
                title: lang.get('area'),
                width: 'auto',
                sortable: true,
                type: 'string',
                autoHide: false,
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
                width: 'auto',
                sortable: true,
                type: 'string',
                className: 'dt-center',
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
                width: 'auto',
                sortable: true,
                type: 'string',
                className: 'dt-center',
                template: function(data) {
                    let output = '';
                    $.each(data.lessons, function(key, lesson) {
                        output += '<p>'+ lesson.refactored_time_from + ' ' + lesson.refactored_time_to + '</p>';
                    });
                    return output;
                }
            }]
        });
    }

    //Указатель периода для занятий
    if ($('#schedule_kt_dashboard_daterangepicker').length != 0) {
        let picker = $('#schedule_kt_dashboard_daterangepicker');
        let format = 'D.MM.YYYY';
        let start = moment();
        let end = moment();

        function cb(start, end, label) {
            var title = '';
            var range = '';

            if ((end - start) < 100 || label == lang.get('today')) {
                title = lang.get('today');
                range = start.format(format);
            } else if (label == lang.get('yesterday')) {
                title = lang.get('yesterday');
                range = start.format(format);
            } else {
                range = start.format(format) + ' - ' + end.format(format);
            }

            $('#schedule_kt_dashboard_daterangepicker_title').html(range);
            $('#schedule_kt_dashboard_daterangepicker_date').html(title);
            //$('#schedule_kt_dashboard_daterangepicker_val').val(range);
            if (label != '') {
                $('#kt_datatable_schedule').KTDatatable().spinnerCallback(true);
                $('#kt_datatable_schedule').KTDatatable().search(range, 'date');
            }
        }

        let ranges = {};
        ranges[lang.get('today')] = [moment(), moment()];
        ranges[lang.get('yesterday')] = [moment().subtract(1, 'days'), moment().subtract(1, 'days')];
        ranges[lang.get('last_7_days')] = [moment().subtract(6, 'days'), moment()];
        ranges[lang.get('last_30_days')] = [moment().subtract(29, 'days'), moment()];
        ranges[lang.get('this_month')] = [moment().startOf('month'), moment().endOf('month')];
        ranges[lang.get('last_month')] = [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')];

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

        picker.daterangepicker({
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
                        pageSizeSelect: [5, 10, 20, 30, 50, 100]
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


});