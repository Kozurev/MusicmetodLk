<?php

namespace App\Http\Controllers\Client;


use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\LessonSaveClientRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Api\Schedule;
use App\Api\Facade as Api;

/**
 * Class ScheduleController
 * @package App\Http\Controllers\Client
 */
class ScheduleController extends Controller
{
    /**
     * Страница подбора времени для самостоятельной постановки в график
     *
     * @param Request $request
     * @return View
     */
    public function findTeacherTime(Request $request) : View
    {
        $errors = [];
        $teacherId = intval($request->input('teacherId', 0));
        $date = $request->input('date', null);
        $teachers = collect([]);
        $teacherSchedule = [];
        $teacherNearestTime = [];
        $scheduleTeacherId = null;

        if (!is_null($date)) {
            $date = Carbon::parse($date)->format('Y-m-d');
        }

        //Получение списка преподавателей клиента
        $teachersResponse = User::getTeachers();
        if ($teachersResponse->status == false) {
            $errors['teachers'] = Api::getResponseErrorMessage($teachersResponse);
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
                    $errors['teacher_schedule'] = Api::getResponseErrorMessage($teacherSchedule);
                } else {
                    $teacherSchedule = (array)$teacherSchedule->schedule;
                    if (empty($teacherSchedule)) {
                        $errors['teacher_schedule'] = __('pages.error-teacher-schedule-empty');
                    } else {
                        //Получение возможного времени занятия преподавателя
                        if (!is_null($date)) {
                            $teacherNearestTime = User::getTeacherNearestTime($scheduleTeacherId, $date);
                        }
                    }
                }
            }
        }

        return view(User::getRoleTag(User::ROLE_CLIENT) . '.schedule.time', compact('teachers', 'teacherSchedule', 'teacherNearestTime', 'date', 'scheduleTeacherId'))
            ->with(['customErrors' => collect($errors)]);
    }

    /**
     * Постановка в график (создание занятия)
     *
     * @param LessonSaveClientRequest $request
     * @return RedirectResponse
     */
    public function makeLesson(LessonSaveClientRequest $request) : RedirectResponse
    {
        $teacherId = $request->input('teacherId');
        $lessonTime = json_decode($request->input('time'));

        $lessonData = [
            Schedule::PARAM_LESSON_DATE => $lessonTime->date,
            Schedule::PARAM_LESSON_AREA_ID => $lessonTime->area_id,
            Schedule::PARAM_LESSON_CLASS_ID => $lessonTime->class_id,
            Schedule::PARAM_LESSON_SCHEDULE_TYPE => Schedule::SCHEDULE_TYPE_CURRENT,
            Schedule::PARAM_LESSON_TYPE_ID => Schedule::TYPE_SINGLE,
            Schedule::PARAM_LESSON_TEACHER_ID => $teacherId,
            Schedule::PARAM_LESSON_TIME_FROM => $lessonTime->timeFrom,
            Schedule::PARAM_LESSON_TIME_TO => $lessonTime->timeTo
        ];

        $response = User::lessonSave($lessonData);
        if ($response->status == true) {
            return redirect()->back()->with('success', __('pages.lesson-saved-success', [
                'date' => date('d.m.Y', strtotime($lessonTime->date)),
                'timeFrom' => $lessonTime->refactoredTimeFrom,
                'timeTo' => $lessonTime->refactoredTimeTo,
            ]));
        } else {
            return redirect()->back()->withErrors(['request' => $response->message ?? '']);
        }
    }

}
