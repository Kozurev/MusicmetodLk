<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('index');

Route::get('/login', 'LoginController@index')->name('login.index')->middleware('guest');
Route::post('/login/auth', 'LoginController@auth')->name('login.make')->middleware('guest');
Route::get('/logout', 'LoginController@logout')->name('login.logout');

Route::get('/balance', 'BalanceController@index')->name('balance.index');
Route::post('/balance/makePayment', 'BalanceController@makeDeposit')->name('balance.makeDeposit');
Route::get('/balance/success', 'BalanceController@depositSuccess')->name('balance.depositSuccess');
Route::get('/balance/error', 'BalanceController@depositError')->name('balance.depositError');

Route::get('/rates', 'RatesController@index')->name('rates.index');
Route::get('/rates/buy/{id}', 'RatesController@buyPrepare')->name('rates.buy.prepare');
Route::post('/rates/buy/{id}', 'RatesController@buyExecute')->name('rate.buy.execute');

Route::get('/schedule/time', 'ScheduleController@findTeacherTime')->name('schedule.find_teacher_time');
Route::post('/schedule/makeLesson', 'ScheduleController@makeLesson')->name('schedule.make_lesson');
Route::post('/schedule/lesson-absent', 'ScheduleController@lessonAbsent')->name('schedule.absent_lesson');

Route::get('/faq', 'FaqController@index')->name('faq.index');
