/**
 * Иннициализация AJAX-формы
 *
 * @param formSelector
 * @param successCallback
 * @param errorCallback
 */
function initAjaxForm(formSelector, successCallback, errorCallback) {
    $(document).on('submit', formSelector, function(e) {
        e.preventDefault();
        let $form = $(formSelector);
        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: $form.serialize(),
            dataType: 'json',
            success: function(response) {
                if (typeof successCallback === 'function') {
                    successCallback(response);
                } else {
                    ajaxFormSuccessCallbackDefault(response);
                }
            },
            error: function (response) {
                if (typeof errorCallback === 'function') {
                    errorCallback(response);
                } else {
                    ajaxFormErrorCallbackDefault(response);
                }
            }
        });
    });
}

/**
 * Калбэк функция по умолчанию для положительного ответа
 *
 * @param response
 */
function ajaxFormSuccessCallbackDefault(response) {
    alert.fire({
        type: response.status !== undefined ? response.status : 'success',
        title: response.message !== undefined ? response.message : '',
    });
}

/**
 * Калбэк функция по умолчанию для ответа с ошибкой
 *
 * @param response
 */
function ajaxFormErrorCallbackDefault(response) {
    let message = '';
    if (response.responseJSON.errors !== undefined) {
        $.each(response.responseJSON.errors, function(key, error) {
            message += error + '; ';
        });
    } else {
        message = (response.responseJSON.message !== undefined) ? response.responseJSON.message : 'Server error 500';
    }
    alert.fire({
        type: 'error',
        title: message
    });
}

/**
 * Удаление наблюдателей для ранее иннициализированной AJAX формы
 *
 * @param formSelector
 */
function removeAjaxForm(formSelector) {
    $(document).off('submit', formSelector);
}