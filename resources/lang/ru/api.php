<?php
return [
    'payment-type-1' => 'Пополнение',
    'payment-type-2' => 'Списание',
    'payment-type-3' => 'Выплата преподавателю',
    'payment-type-15' => 'Кэшбэк',
    'payment-type-16' => 'Зачисление премии',
    'payment-type-17' => 'Выплата премии',
    'payment-type-21' => 'Бонус',
    'payment-type-23' => 'Возврат средств',

    'payment-status-0' => 'Обрабатывается',
    'payment-status-1' => 'Выполнен',
    'payment-status-2' => 'Ошибка',

    'report-attendance-0' => 'Отсутствовал(а)',
    'report-attendance-1' => 'Присутствовал(а)',

    'error-undefined' => 'Неизвестная ошибка API',

    'errors' => [
        \App\Api\ApiResponse::ERROR_CODE_AUTH => 'Польователь не авторизован',
        \App\Api\ApiResponse::ERROR_CODE_ACCESS => 'Доступ запрещен',
        \App\Api\ApiResponse::ERROR_CODE_NOT_FOUND => 'Объект не найден',
        \App\Api\ApiResponse::ERROR_CODE_TIME => 'В данное время действие недоступно',
        \App\Api\ApiResponse::ERROR_CODE_REQUIRED_PARAM => 'Отсутствует один или несколько обязательных параметров запроса',
        \App\Api\ApiResponse::ERROR_CODE_PASSWORD_CONFIRMATION => 'Пароли не совпадают',
        \App\Api\ApiResponse::ERROR_CODE_PASSWORD_OLD => 'Невено введен старый пароль'
    ]
];
