<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewLessonRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Api\Facade as Api;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Страница подбора времени для самостоятельной постановки в график
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function findTeacherTime(Request $request)
    {
        User::fresh();
        $user = User::current();
        $errors = [];
        $teacherId = intval($request->input('teacherId', 0));
        $date = $request->input('date', Carbon::tomorrow()->format('Y-m-d'));
        $date = Carbon::parse($date)->format('Y-m-d');

        //Получение списка преподавателей клиента
        $teachersResponse = User::getTeachers();
        if ($teachersResponse->status == false) {
            $errors['teachers'] = $teachersResponse->message ?? '';
        } else {
            $teachers = collect($teachersResponse->teachers ?? []);
            if (count($teachers) == 0) {
                $errors['teachers'] = __('pages.error-teachers-empty');
            }

            //Получение графика работы преподавателя
            if (!empty($teacherId) || count($teachers) > 0) {
                $scheduleTeacherId = !empty($teacherId) ? $teacherId : $teachers[0]->id ?? 0;
                $teacherSchedule = User::getTeacherSchedule($scheduleTeacherId);
                if ($teacherSchedule->status == false) {
                    $errors['teacher_schedule'] = $teacherSchedule->message ?? '';
                } else {
                    $teacherSchedule = (array)$teacherSchedule->schedule;
                    if (empty($teacherSchedule)) {
                        $errors['teacher_schedule'] = __('pages.error-teacher-schedule-empty');
                    } else {
                        //Получение возможного времени занятия преподавателя
                        $teacherNearestTime = User::getTeacherNearestTime($scheduleTeacherId, $date);
                    }
                }
            }
        }

        return view('schedule.time', compact('user', 'teachers', 'teacherSchedule', 'teacherNearestTime', 'date', 'scheduleTeacherId'))
            ->with(['customErrors' => collect($errors)]);
    }


    public function makeLesson(NewLessonRequest $request)
    {
        $teacherId = $request->input('teacherId');
        $lessonTime = $request->input('time');
        $timeSegments = explode(' - ', $lessonTime);

        $timeFrom = $timeSegments[0];
        $timeTo = $timeSegments[1];
        dd($teacherId, $timeFrom, $timeTo);
    }

}
