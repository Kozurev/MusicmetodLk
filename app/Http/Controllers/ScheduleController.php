<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewLessonRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Api\Schedule;

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

    /**
     * @param NewLessonRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function makeLesson(NewLessonRequest $request)
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


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function lessonAbsent(Request $request)
    {
        $lessonId = $request->input('lesson_id', 0);
        $date = $request->input('date', '');
        $response = User::lessonAbsent($lessonId, $date);
        $message = ($response->status ?? true) == false
            ?   $response->message
            :   __('pages.lesson-cancel-success');

        return response()->json([
            'status' => ($response->status ?? true) == true ? 'success' : 'error',
            'message' => $message
        ]);
    }

}
