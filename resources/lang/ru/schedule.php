<?php
return [
    'lesson-types' => [
        \App\Api\Schedule::TYPE_SINGLE          => 'Индивидуальное занятие',
        \App\Api\Schedule::TYPE_GROUP           => 'Групповое занятие',
        \App\Api\Schedule::TYPE_CONSULT         => 'Консультация',
        \App\Api\Schedule::TYPE_GROUP_CONSULT   => 'Групповая консультация',
        \App\Api\Schedule::TYPE_PRIVATE         => 'Частное занятие',
    ],

    'schedule-types' => [
        \App\Api\Schedule::SCHEDULE_TYPE_MAIN       => 'Основной график',
        \App\Api\Schedule::SCHEDULE_TYPE_CURRENT    => 'Актуальный график'
    ]
];
