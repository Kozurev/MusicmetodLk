<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
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
}
