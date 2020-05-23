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
Route::get('schedule', 'Api\ScheduleController@dataTable')->name('schedule.data');
Route::get('rates', 'Api\RatesController@dataTable')->name('rates.data');