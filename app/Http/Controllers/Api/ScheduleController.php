<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\LessonReportRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\AbsentPeriodSaveRequest;
use App\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Api\Facade as Api;

class ScheduleController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function dataTable(Request $request) : JsonResponse
    {
        $params = $request->all();
        if (empty($params['query']['date'] ?? '')) {
            $params['date_start'] = date('Y-m-d');
            $params['date_end'] = Carbon::make($params['date_start'])->addDays(6)->format('Y-m-d');
        } else {
            $dates = explode(' - ', $params['query']['date'] ?? '');
            $params['date_start'] = !empty($dates[0]) ? $dates[0] : date('Y-m-d');
            $params['date_end'] = $dates[1] ?? $params['date_start'];
        }

        $params['date_start'] = date('Y-m-d', strtotime($params['date_start']));
        $params['date_end'] = date('Y-m-d', strtotime($params['date_end']));

        unset($params['query']);

        return response()->json([
            'data' => User::getScheduleShort($params)
        ]);
    }

    /**
     * Обработчик для AJAX запроса отмены занятия
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function lessonAbsent(Request $request) : JsonResponse
    {
        $lessonId = $request->input('lesson_id', 0);
        $date = $request->input('date', '');
        try {
            User::lessonAbsent($lessonId, $date);
            return response()->json([
                'status' => 'success',
                'message' => __('pages.lesson-cancel-success')
            ]);
        } catch (\Throwable $throwable) {
            return response()->json([
                'status' => 'error',
                'message' => $throwable->getMessage()
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function absentsDataTable(Request $request) : JsonResponse
    {
        $params = $request->all();
        if (empty($params[Api::PARAM_DATE_FROM] ?? null)) {
            $params[Api::PARAM_DATE_FROM] = date('Y-m-d');
        }
        unset($params['query']);
        $response = User::getAbsentPeriods($params);

        foreach ($response->data ?? [] as $period) {
            $period->refactored_date_from = Carbon::parse($period->date_from)->format('d.m.Y');
            $period->refactored_date_to = Carbon::parse($period->date_to)->format('d.m.Y');
        }
        return response()->json($response);
    }

    /**
     * @param AbsentPeriodSaveRequest $request
     * @return JsonResponse
     */
    public function absentSave(AbsentPeriodSaveRequest $request) : JsonResponse
    {
        $response = User::saveAbsentPeriod([
            Api::PARAM_DATE_FROM => $request->input('date_from'),
            Api::PARAM_DATE_TO => $request->input('date_to')
        ]);
        if (($response->status ?? true) === false) {
            $status = 'error';
            $message = $response->message;
        } else {
            $status = 'success';
            $message = __('pages.absent-period-create-success');
        }
        return response()->json(compact('status', 'message'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function absentDelete(Request $request) : JsonResponse
    {
        $id = $request->input('id', 0);
        $response = User::deleteAbsentPeriod($id);
        $status = empty($response->error ?? null);
        $message = $response->message ?? __('pages.absent-period-delete-success');
        return response()->json(compact('status', 'message'));
    }

    /**
     * @param LessonReportRequest $request
     * @return JsonResponse
     */
    public function makeLessonReport(LessonReportRequest $request) : JsonResponse
    {
        $response = Api::instance()->lessonReport(User::getToken(), $request->except(['_token', 'token']));
        if (($response->status ?? true) === false) {
            $status = 'error';
            $message = $response->message;
        } else {
            $status = 'success';
            $message = __('pages.lesson-report-success');
        }
        return response()->json(compact('status', 'message'));
    }
}
