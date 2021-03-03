<?php

namespace App\Http\Controllers\Teacher;

use App\Api\ApiResponse;
use App\Api\Schedule;
use App\Http\Controllers\Controller;
use App\Http\Requests\LessonSaveTeacherRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Psy\Util\Json;

/**
 * Class ScheduleController
 * @package App\Http\Controllers\Teacher
 */
class ScheduleController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        try {
            $areas = User::getAreas();

            $date = Carbon::parse(request('date', date('Y-m-d')));
            $areaId = (int)request('area_id', $areas->first()->id ?? 0);

            $schedule = collect(!empty($areaId) ? User::getScheduleFull($areaId, $date->format('Y-m-d'))->get('schedule') ?? [] : []);
            $clients = User::getClients();

        } catch (\Throwable $throwable) {
            $error = $throwable->getMessage();
        }

        $timeStart = Carbon::now()->setHour(9)->setMinute(0)->setSecond(0);
        $timeEnd = Carbon::now()->setHour(22)->setMinute(0)->setSecond(0);
        $timeMinutesStep = 15;

        return view('teacher.schedule', [
            'date' => $date ?? Carbon::now(),
            'areas' => $areas ?? collect(),
            'areaId' => $areaId ?? 0,
            'schedule' => $schedule ?? collect(),
            'clients' => $clients ?? collect(),
            'timeStart' => $timeStart,
            'timeEnd' => $timeEnd,
            'timeMinutesStep' => $timeMinutesStep,
            'lessonTypes' => [
                Schedule::TYPE_SINGLE => Schedule::getTypeName(Schedule::TYPE_SINGLE),
                Schedule::TYPE_PRIVATE => Schedule::getTypeName(Schedule::TYPE_PRIVATE)
            ]
        ])->withErrors([$error ?? null]);
    }

    /**
     * @param LessonSaveTeacherRequest $request
     * @return JsonResponse
     */
    public function saveLesson(LessonSaveTeacherRequest $request): JsonResponse
    {
        $lessonData = [
            Schedule::PARAM_LESSON_DATE => $request->date,
            Schedule::PARAM_LESSON_AREA_ID => $request->area_id,
            Schedule::PARAM_LESSON_CLASS_ID => $request->class_id,
            Schedule::PARAM_LESSON_SCHEDULE_TYPE => Schedule::SCHEDULE_TYPE_CURRENT,
            Schedule::PARAM_LESSON_TYPE_ID => $request->type_id,
            Schedule::PARAM_LESSON_CLIENT_ID => $request->client_id,
            Schedule::PARAM_LESSON_TIME_FROM => $request->lesson_time_from . ':00',
            Schedule::PARAM_LESSON_TIME_TO => $request->lesson_time_to . ':00'
        ];

        $response = User::lessonSave($lessonData);
        if ($response->status == true) {
            $response = [
                'status' => 'success',
                'message' => __('pages.lesson-saved-success', [
                    'date' => date('d.m.Y', strtotime($request->date)),
                    'timeFrom' => $request->lesson_time_from,
                    'timeTo' => $request->lesson_time_to
                ])
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => $response->message
            ];
        }

        return response()->json($response);
    }
}
