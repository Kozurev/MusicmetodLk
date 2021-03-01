<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\View\View;

/**
 * Class ScheduleController
 * @package App\Http\Controllers\Teacher
 */
class ScheduleController extends Controller
{
    public function index(): View
    {
        $areas = User::getAreas();

        $date = Carbon::parse(request('date', date('Y-m-d')));
        $areaId = (int)request('area_id', $areas->first()->id ?? 0);

        $schedule = collect(!empty($areaId) ? User::getScheduleFull($areaId, $date)->schedule ?? [] : []);

        $timeStart = Carbon::now()->setHour(9)->setMinute(0)->setSecond(0);
        $timeEnd = Carbon::now()->setHour(22)->setMinute(0)->setSecond(0);
        $timeMinutesStep = 15;

        return view('teacher.schedule', compact('date', 'areas', 'areaId', 'schedule', 'timeStart', 'timeEnd', 'timeMinutesStep'));
    }
}
