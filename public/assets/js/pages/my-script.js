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
    if ($('#kt_datatable_payments_history').length !== 0) {
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
                    noRecords: lang('no_payments')
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
            pagination: true,
            columns: [{
                field: "datetime",
                title: lang('date'),
                width: 55,
                sortable: true,
                autoHide: false,
                template: function(data) {
                    return '<span>'+data.refactored_date+'</span>';
                }
            }, {
                field: "type",
                title: lang('type'),
                width: 100,
                autoHide: false,
                sortable: true,
                className: 'dt-center',
                template: function(data, i) {
                    let statusClass = '';
                    switch (Number(data.type)) {
                        case 1: statusClass = 'btn-label-success';    break;
                        case 15: statusClass = 'btn-label-success';    break;
                        case 21: statusClass = 'btn-label-success';    break;
                        case 2: statusClass = 'btn-label-danger';     break;
                        case 23: statusClass = 'btn-label-danger';     break;
                        default:  statusClass = 'btn-label-warning';    break;
                    }
                    return '<span class="btn btn-bold btn-sm btn-font-sm '+statusClass+'">'+lang('payment_type_' + data.type)+'</span>';
                }
            }, {
                field: "status",
                title: lang('status'),
                width: 'auto',
                autoHide: false,
                sortable: true,
                className: 'dt-center',
                template: function(data, i) {
                    let statusClass = '';
                    switch (Number(data.status)) {
                        case 1: statusClass = 'btn-label-success';    break;
                        case 2: statusClass = 'btn-label-danger';     break;
                        default:  statusClass = 'btn-label-warning';    break;
                    }
                    return '<span class="btn btn-bold btn-sm btn-font-sm '+statusClass+'">'+lang('payment_status_' + data.status)+'</span>';
                }
            }, {
                field: "value",
                title: lang('amount'),
                width: 60,
                sortable: true,
                className: 'dt-center',
                template: function(data) {
                    return '<span>'+data.value+' <i class="fa fa-ruble-sign"></i></span>';
                }
            }, {
                field: "description",
                title: lang('note'),
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

    //Таблица истории посещения занятий клиентом
    if ($('#kt_datatable_schedule_history').length !== 0) {
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
                    noRecords: lang('no_reports')
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
                title: lang('date'),
                width: 60,
                sortable: true,
                type: 'string',
                autoHide: false,
                template: function(data) {
                    return '<span>'+data.refactored_date+'</span>';
                }
            }, {
                field: "time",
                title: lang('time'),
                width: 80,
                sortable: false,
                type: 'string',
                autoHide: false,
                template: function(data) {
                    return '<span>'+data.lesson_time_from+' - '+data.lesson_time_to+'</span>';
                }
            }, {
                field: "attendance",
                title: lang('status'),
                width: 'auto',
                autoHide: false,
                sortable: false,
                className: 'dt-center',
                template: function(data, i) {
                    let statusClass = '';
                    switch (Number(data.attendance)) {
                        case 1: statusClass = 'btn-label-success';    break;
                        case 0: statusClass = 'btn-label-danger';     break;
                        default:  statusClass = 'btn-label-warning';    break;
                    }
                    return '<span class="btn btn-bold btn-sm btn-font-sm '+statusClass+'">'+lang('report_attendance_' + data.attendance)+'</span>';
                }
            }, {
                field: "teacher_id",
                title: lang('teacher'),
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
    if ($('#kt_datatable_schedule').length !== 0) {
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
                    noRecords: lang('no_lessons')
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
                title: lang('date'),
                width: 100,
                sortable: false,
                class: 'dt-center',
                autoHide: false,
                template: function(data) {
                    return '<span>'+data.refactored_date+'</span>';
                }
            }, {
                field: "area_id",
                title: lang('area'),
                sortable: false,
                width: 150,
                class: 'dt-center',
                autoHide: true,
                template: function(data) {
                    let output = '';
                    $.each(data.lessons, function(key, lesson) {
                        output += '<p>'+ lesson.area.title +'</p>';
                    });
                    return output;
                }
            }, {
                field: "teacher_id",
                title: lang('teacher'),
                width: 200,
                sortable: false,
                autoHide: true,
                template: function(data) {
                    let output = '';
                    $.each(data.lessons, function(key, lesson) {
                        output += '<p>'+ lesson.teacher.surname + ' ' + lesson.teacher.name +'</p>';
                    });
                    return output;
                }
            }, {
                field: "time",
                title: lang('time'),
                width: 150,
                sortable: true,
                type: 'string',
                // class: 'dt-right',
                autoHide: true,
                template: function(data) {
                    let output = '<div style="width: 100%; text-align: left; margin-right: 25px">';
                    $.each(data.lessons, function(key, lesson) {
                        output += ''+lesson.refactored_time_from + ' ' + lesson.refactored_time_to + '';
                        output += '<div class="dropdown" style="display: inline-block">' +
                                        '<a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md" aria-expanded="false">' +
                                            '<i class="la la-cog"></i>' +
                                        '</a>' +
                                    '<div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="display: none; position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(1474px, 531px, 0px);">' +
                                        '<a href="#" class="dropdown-item lessonCancel" data-lesson="'+lesson.id+'" data-date="'+data.date+'">' +
                                            '<i class="flaticon-circle"></i> '+lang('cancel')+
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

        function cb(start, end, label, isFirstInit = false) {
            var title = '';
            var range = '';

            if (label !== lang('daterangepicker_customRangeLabel')) {
                if (label === '') {
                    label = lang('week');
                }
                title = label;
                range = start.format(format) + ' - ' + end.format(format);
            }

            $('#schedule_kt_dashboard_daterangepicker_title').html(range);
            $('#schedule_kt_dashboard_daterangepicker_date').html(title);
            if (label !== '' && !isFirstInit) {
                $scheduleTable.KTDatatable().spinnerCallback(true);
                $scheduleTable.KTDatatable().search(range, 'date');
            }
        }

        let ranges = {};
        ranges[lang('last_7_days')] = [moment(), moment().add(6, 'days')];
        ranges[lang('last_30_days')] = [moment(), moment().add(29, 'days')];
        ranges[lang('this_month')] = [moment().startOf('month'), moment().endOf('month')];
        ranges[lang('next_month')] = [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')];

        $scheduleRangePicker.daterangepicker({
            direction: KTUtil.isRTL(),
            startDate: start,
            endDate: end,
            opens: 'left',
            ranges: ranges,
        }, cb);

        cb(start, end, '', true);
    }

    //Таблица абонементов
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
                    noRecords: lang('no_rates')
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
                title: lang('title'),
                width: 'auto',
                sortable: true,
                type: 'string',
                autoHide: false,
                template: function(data) {
                    console.log(data);
                    return '<span>'+data.title+'</span>';
                }
            }, {
                field: "countIndiv",
                title: lang('count_indiv'),
                width: 'auto',
                sortable: true,
                type: 'number',
                className: 'dt-center',
                template: function(data) {
                    return '<span>'+data.count_indiv+'</span>';
                }
            }, {
                field: "countGroup",
                title: lang('count_group'),
                width: 'auto',
                sortable: true,
                type: 'number',
                className: 'dt-center',
                template: function(data) {
                    return '<span>'+data.count_group+'</span>';
                }
            }, {
                field: "price",
                title: lang('price'),
                width: 'auto',
                // autoHide: false,
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
                    return '<a href="/client/rates/buy/'+data.id+'" class="btn btn-sm btn-success">'+lang('buy')+'</a>&nbsp;';
                        // +   '<a href="/client/rates/buy/' + data.id + '/credit" class="btn btn-sm btn-warning">'+lang('buy_credit')+'</a>';
                }
            }]
        });
    }

    //Таблица периодов отсутствия
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
                    noRecords: lang('no_periods')
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
                title: lang('date_from'),
                width: 70,
                sortable: true,
                type: 'string',
                autoHide: false,
                template: function(data) {
                    return '<span>'+data.refactored_date_from+'</span>';
                }
            }, {
                field: "date_to",
                title: lang('date_to'),
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
                                            '<i class="flaticon2-trash"></i> '+lang('cancel')+
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
            $('#client_kt_datatable_schedule').KTDatatable().reload();
        });
    }

    $(document)
        //Отмена занятия клиентом
        .on('click', '.lessonCancel', function(e) {
            e.preventDefault();
            let lessonId = $(this).data('lesson');
            let date = $(this).data('date');
            alert.fire({
                title: lang('lesson_cancel_alert'),
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: lang('yes'),
                cancelButtonText: lang('no'),
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: '/api/schedule/lesson/absent',
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
                        },
                        error: function(response) {
                            alert.fire({
                                type: response.responseJSON.status,
                                title: response.responseJSON.message
                            });
                        }
                    });
                }
            });
        })
        .on('click', '.absentPeriodDelete', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            alert.fire({
                title: lang('absent_period_delete_alert'),
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: lang('yes'),
                cancelButtonText: lang('no'),
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
                            $('#kt_datatable_schedule').KTDatatable().reload();
                        }
                    });
                }
            });
        })
        .on('click', '.makeReport', function(e) {
            e.preventDefault();
            let
                $form = $(this).parent().parent().find('form');
            alert.fire({
                title: lang('make_lesson_report_alert'),
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: lang('yes'),
                cancelButtonText: lang('no'),
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $form.find('input[name=token]').val($('meta[name=token]').attr('content'));
                    $.ajax({
                        type: 'POST',
                        url: '/api/schedule/lesson/report',
                        dataType: 'json',
                        data: $form.serialize(),
                        success: function(response) {
                            alert.fire({
                                type: response.status,
                                title: response.message
                            }).then((result) => {
                                console.log(response);
                                if (response.status === 'success') {
                                    location.reload();
                                }
                            });
                        }
                    });
                }
            });
        })
        .on('change', 'input[name=attendance]', function(e) {
            let
                checked = $(this).is(':checked'),
                $list = $(this).parent().find('ul.report-attendance-list');
            if ($list.length > 0) {
                $list.find('input[type=checkbox]').each(function(key, input) {
                    if (checked) {
                        $(input).attr('checked', 'checked');
                    } else {
                        $(input).removeAttr('checked');
                    }
                });
            }
        })
        .on('click', '.lesson-time-modify', function(e) {
            e.preventDefault();
            let $modal = $('#lessonTimeModifyModal');
            $modal.find('input[name=lesson_id]').val($(this).data('lesson_id'));
            $modal.modal();
        })
        .on('click', '.lesson-cancel', function(e) {
            e.preventDefault();
            alert.fire({
                title: lang('lesson_cancel_alert'),
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: lang('yes'),
                cancelButtonText: lang('no'),
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: '/teacher/schedule/lesson/absent',
                        data: {
                            _token: $('meta[name=csrf_token]').attr('content'),
                            token: $('meta[name=token]').attr('content'),
                            lesson_id: $(this).data('lesson_id'),
                            date: $(this).data('date')
                        },
                        success: function(response) {
                            ajaxFormSuccessCallbackDefault(response, function(result) {
                                window.location.reload();
                            });
                        },
                        error: function(response) {
                            ajaxFormErrorCallbackDefault(response);
                        }
                    });
                }
            });
        })
        .on('change', '.p2p_receiver', function (e) {
            e.preventDefault();
            let fio = $(this).data('fio'),
                card_number = $(this).data('card_number'),
                phone_number = $(this).data('phone_number'),
                comment = $(this).data('comment'),
                $modalFio = $('#p2p_fio'),
                $modalCardNumber = $('#p2p_card'),
                $modalPhoneNumber = $('#p2p_phone'),
                $modalComment = $('#p2p_comment');

            $('#receiver_id').val($(this).val());
            $modalFio.text(fio);
            if (card_number !== '') {
                $modalCardNumber.text(card_number);
                $modalCardNumber.parent().parent().show();
            } else {
                $modalCardNumber.parent().parent().hide();
            }
            if (phone_number !== '') {
                $modalPhoneNumber.text(phone_number);
                $modalPhoneNumber.parent().parent().show();
            } else {
                $modalPhoneNumber.parent().parent().hide();
            }
            if (comment !== '') {
                $modalComment.text(comment);
                $modalComment.parent().parent().show();
            } else {
                $modalComment.parent().parent().hide();
            }
        });


    if ($('#kt_teacher_short_schedule_datepicker').length !== 0) {
        $('#kt_teacher_short_schedule_datepicker').datepicker({
            rtl: KTUtil.isRTL(),
            orientation: "bottom right",
            todayHighlight: true,
            format: 'dd.mm.yyyy'
        });
    }

    if ($('.datepicker').length !== 0) {
        $('.datepicker').each(function(key, input) {
            $(input).datepicker({
                rtl: KTUtil.isRTL(),
                orientation: "bottom right",
                todayHighlight: true,
                format: 'dd.mm.yyyy'
            });
        });
    }

    if ($('#teacherLessonForm').length !== 0) {
        initAjaxForm('#teacherLessonForm', function(response) {
            ajaxFormSuccessCallbackDefault(response, function(modalValue) {
                window.location.reload();
            });
        });
    }
    if ($('#lessonTimeModifyForm').length !== 0) {
        initAjaxForm('#lessonTimeModifyForm', function(response) {
            ajaxFormSuccessCallbackDefault(response, function(modalValue) {
                window.location.reload();
            });
        });
    }

    if ($('.masked-phone').length !== 0) {
        $('.masked-phone').mask('+79999999999');
    }

    if ($('.p2p_receiver').length) {
        $('.p2p_receiver').trigger('change');
    }

});
