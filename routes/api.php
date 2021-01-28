<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('payments', 'Api\PaymentsController@dataTable')->name('payments.data');
Route::get('reports', 'Api\ReportsController@dataTable')->name('reports.data');
Route::get('rates', 'Api\RatesController@dataTable')->name('rates.data');
Route::get('schedule', 'Api\ScheduleController@dataTable')->name('schedule.data');
Route::post('schedule/lesson/report', 'Api\ScheduleController@makeLessonReport')->name('schedule.lesson_report');
Route::post('schedule/lesson/absent', 'Api\ScheduleController@lessonAbsent')->name('schedule.absent_lesson');
Route::get('schedule/absents/list', 'Api\ScheduleController@absentsDataTable')->name('schedule.absents.list');
Route::post('schedule/absents/save', 'Api\ScheduleController@absentSave')->name('schedule.absents.save');
Route::post('schedule/absents/delete', 'Api\ScheduleController@absentDelete')->name('schedule.absents.delete');