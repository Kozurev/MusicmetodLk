<?php


namespace App\Api;


class Schedule
{
    const TYPE_SINGLE = 1;
    const TYPE_GROUP = 2;
    const TYPE_CONSULT = 3;
    const TYPE_GROUP_CONSULT = 4;

    const SCHEDULE_TYPE_MAIN = 1;
    const SCHEDULE_TYPE_CURRENT = 2;

    const PARAM_LESSON_DATE = 'insertDate';
    const PARAM_LESSON_SCHEDULE_TYPE = 'scheduleType';
    const PARAM_LESSON_TYPE_ID = 'typeId';
    const PARAM_LESSON_CLIENT_ID = 'clientId';
    const PARAM_LESSON_TEACHER_ID = 'teacherId';
    const PARAM_LESSON_AREA_ID = 'areaId';
    const PARAM_LESSON_CLASS_ID = 'classId';
    const PARAM_LESSON_TIME_FROM = 'timeFrom';
    const PARAM_LESSON_TIME_TO = 'timeTo';

    /**
     * @var int[]
     */
    public static $types = [
        self::TYPE_SINGLE,
        self::TYPE_GROUP,
        self::TYPE_CONSULT,
        self::TYPE_GROUP_CONSULT
    ];

    /**
     * @var int[]
     */
    public static $scheduleTypes = [
        self::SCHEDULE_TYPE_MAIN,
        self::SCHEDULE_TYPE_CURRENT
    ];

    /**
     * @return array|int[]
     */
    public static function getTypes() : array
    {
        return self::$types;
    }

    /**
     * @param int $type
     * @return string
     */
    public static function getTypeName(int $type) : string
    {
        return __('schedule.lesson-type-' . $type);
    }

    /**
     * @return array
     */
    public static function getTypeNames() : array
    {
        $output = [];
        foreach (self::getTypes() as $type) {
            $output[$type] = self::getTypeName($type);
        }
        return $output;
    }

    /**
     * @return array|int[]
     */
    public static function getScheduleTypes() : array
    {
        return self::$scheduleTypes;
    }

    /**
     * @param int $type
     * @return string
     */
    public static function getScheduleTypeName(int $type) : string
    {
        return __('schedule.schedule-type-' . $type);
    }

    /**
     * @return array
     */
    public static function getScheduleTypeNames() : array
    {
        $output = [];
        foreach (self::getScheduleTypes() as $type) {
            $output[$type] = self::getScheduleTypeName($type);
        }
        return $output;
    }

}
