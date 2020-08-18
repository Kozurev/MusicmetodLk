<?php

namespace App\Http\Controllers\Api;

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function dataTable(Request $request)
    {
        $params = $request->all();
        if (empty($params['query']['date'] ?? '')) {
            $params['date_start'] = date('Y-m-d');
            $params['date_end'] = $params['date_start'];
        } else {
            $dates = explode(' - ', $params['query']['date'] ?? '');
            $params['date_start'] = !empty($dates[0]) ? $dates[0] : date('Y-m-d');
            $params['date_end'] = $dates[1] ?? $params['date_start'];
        }

        $params['date_start'] = date('Y-m-d', strtotime($params['date_start']));
        $params['date_end'] = date('Y-m-d', strtotime($params['date_end']));

        unset($params['query']);

        return response()->json([
            'data' => User::getSchedule($params)
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function absentsDataTable(Request $request)
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function absentSave(AbsentPeriodSaveRequest $request)
    {
        $response = User::saveAbsentPeriod([
            Api::PARAM_DATE_FROM => $request->input('date_from'),
            Api::PARAM_DATE_TO => $request->input('date_to')
        ]);
        if (($response->status ?? true) === false ) {
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function absentDelete(Request $request)
    {
        $id = $request->input('id', 0);
        $response = User::deleteAbsentPeriod($id);
        $status = empty($response->error ?? null);
        $message = $response->message ?? __('pages.absent-period-delete-success');
        return response()->json(compact('status', 'message'));
    }
}
