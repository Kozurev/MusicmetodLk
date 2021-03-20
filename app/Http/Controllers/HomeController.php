<?php

namespace App\Http\Controllers;

use App\Api\Facade;
use App\Api\Schedule;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * @return RedirectResponse
     */
    public function index() : RedirectResponse
    {
        return redirect(route(User::getRoleTag() . '.index'));
    }

    /**
     * @return View
     */
    public function clientIndex() : View
    {
        $nextLessons = User::getNextLessons();
        return view(User::getRoleTag(User::ROLE_CLIENT) . '.index', compact('nextLessons'));
    }

    /**
     * @param Request $request
     * @return View
     */
    public function teacherIndex(Request $request) : View
    {
        $searchingDate = $request->input('date', date('Y-m-d'));
        $date = Carbon::parse($searchingDate);

        $errors = [];   //список ошибок

        /**
         * Формирование расписание в виде:
         * недели[] => дни[] => [дата, филиал => {данные филиала, занятия => [информация о занятиях]}]
         */
        $countWeeks = 2; //кол-во недель в таблице расписания
        $dateFrom = (clone $date)->startOfWeek()->format('Y-m-d');
        $dateTo = (clone $date)->addWeeks($countWeeks - 1)->endOfWeek()->format('Y-m-d');

        try {
            $schedule = User::getScheduleShort([
                Facade::PARAM_DATE_START => $dateFrom,
                Facade::PARAM_DATE_END => $dateTo
            ]);
        } catch (\Throwable $throwable) {
            $errors[] = $throwable->getMessage();
            $schedule = collect();
        }

        $weeks = [];

        $todayLessons = $schedule->where('date', (clone $date)->format('Y-m-d'))->first()->lessons ?? [];
        for ($weekNum = 0; $weekNum < $countWeeks; $weekNum++) {
            $weekDateStart = (clone $date)->addWeeks($weekNum)->startOfWeek();

            //формирование данных по каждому дню
            $days = [];
            for ($weekDaysNum = 0; $weekDaysNum < 7; $weekDaysNum++) {
                $day = [
                    //дата "текущего" дня
                    'date' => (clone $weekDateStart)->addDays($weekDaysNum)->format('Y-m-d')
                ];
                $lessons = collect($schedule->where('date', $day['date'])->first()->lessons ?? []);

                //данные по филиалам и занятиям в филиалах
                if (!empty($lessons)) {
                    //филиалы, в которых проходят занятия на текущий день
                    $areas = (clone $lessons)->map(function(\stdClass $lessonData) : \stdClass {
                        return $lessonData->area;
                    })->unique('id');

                    //групирование занятий текущего дня по каждому филиалу отдельно
                    $day['areas'] = $areas->map(function(\stdClass $area) use ($lessons) : \stdClass {
                        $area->lessons = $lessons->where('area_id', $area->id)->all();
                        return $area;
                    });
                }

                $days[] = $day;
            }

            $weeks[$weekNum] = $days;
        }

        /**
         * Информация о проведенных занятиях
         */
        $dashboardsData = collect();
        $monthDateFrom = (clone $date)->startOfMonth()->format('Y-m-d');
        $monthDateTo = (clone $date)->endOfMonth()->format('Y-m-d');

        $scheduleStatisticResponse = User::getTeacherScheduleStatistic([
            Facade::PARAM_DATE_FROM => $monthDateFrom,
            Facade::PARAM_DATE_TO => $monthDateTo
        ]);

        if (($scheduleStatisticResponse['status'] ?? true) === false) {
            $errors[] = $scheduleStatisticResponse['message'] ?? __('api.error-undefined');
        } else {
            $scheduleStatistic = collect($scheduleStatisticResponse);
            $totalCountLessons = $scheduleStatistic->whereIn('id', [Schedule::TYPE_SINGLE, Schedule::TYPE_GROUP, Schedule::TYPE_PRIVATE]);
            $dashboardsData->put('count_lessons', $totalCountLessons->sum('count_attendance') + $totalCountLessons->sum('count_absence'));
            $dashboardsData->put('salary_earned', $scheduleStatistic->sum('teacher_rate'));

            $singleStatistic = $scheduleStatistic->where('id', Schedule::TYPE_SINGLE)->first();
            $groupStatistic = $scheduleStatistic->where('id', Schedule::TYPE_GROUP)->first();
            $dashboardsData->put('visits', [
                'single' => [
                    'attendance' => $singleStatistic->count_attendance ?? 0,
                    'absence' => $singleStatistic->count_absence ?? 0
                ],
                'group' => [
                    'attendance' => $groupStatistic->count_attendance ?? 0,
                    'absence' => $groupStatistic->count_absence ?? 0,
                ],
            ]);
        }

        /**
         * Подсчет суммы выплат
         */
        $paymentsResponse = User::getPayments([
            Facade::PARAM_WITHOUT_PAGINATE => true,
            Facade::PARAM_DATE_FROM => $monthDateFrom,
            Facade::PARAM_DATE_TO => $monthDateTo
        ]);
        if (($paymentsResponse['status'] ?? true) === false) {
            $salaryPayed = 0;
            $errors[] = $paymentsResponse['message'] ?? __('api.error-undefined');
        } else {
            $salaryPayed = collect($paymentsResponse)->sum('value');
        }
        $dashboardsData->put('salary_payed', $salaryPayed);

        try {
            $clients = User::getClients();
        } catch (\Throwable $throwable) {
            $errors[] = $throwable->getMessage();
            $clients = collect();
        }

        return view(User::getRoleTag(User::ROLE_TEACHER) . '.index', compact('date', 'weeks', 'dashboardsData', 'todayLessons', 'clients'))
            ->withErrors($errors);
    }
}
