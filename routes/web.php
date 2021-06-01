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

Route::group(['middleware' => ['guest']], function () {
    Route::get('/login', 'LoginController@index')->name('login.index');
    Route::post('/login/auth', 'LoginController@auth')->name('login.make');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/logout', 'LoginController@logout')->name('login.logout');
    Route::get('/', 'HomeController@index')->name('index');
});

Route::group(['prefix' => 'client', 'middleware' => ['auth', 'auth_client']], function () {
    Route::get('/', 'HomeController@clientIndex')->name('client.index');
    Route::get('/balance', 'Client\\BalanceController@index')->name('balance.index');
    Route::post('/balance/makePayment', 'Client\\BalanceController@makeDeposit')->name('balance.makeDeposit');
    Route::get('/balance/success', 'Client\\BalanceController@depositSuccess')->name('balance.depositSuccess');
    Route::get('/balance/error', 'Client\\BalanceController@depositError')->name('balance.depositError');

    Route::get('/rates', 'Client\RatesController@index')->name('rates.index');
    Route::get('/rates/buy/{id}', 'Client\\RatesController@buyPrepare')->name('rates.buy.prepare');
    Route::post('/rates/buy/{id}', 'Client\\RatesController@buyExecute')->name('rate.buy.execute');
    Route::get('/rates/buy/{id}/credit', 'Client\\RatesController@byCredit')->name('rates.buy.credit');

    Route::get('/schedule/time', 'Client\ScheduleController@findTeacherTime')->name('schedule.find_teacher_time');
    Route::post('/schedule/makeLesson', 'Client\\ScheduleController@makeLesson')->name('schedule.make_lesson');

    Route::get('/faq', 'Client\\FaqController@index')->name('faq.index');
});

Route::group(['prefix' => 'teacher', 'middleware' => ['auth', 'auth_teacher']], function () {
    Route::get('/', 'HomeController@teacherIndex')->name('teacher.index');
    Route::get('/schedule', 'Teacher\\ScheduleController@index')->name('teacher.schedule');
    Route::post('/schedule/lesson/save', 'Teacher\\ScheduleController@saveLesson')->name('teacher.schedule.lesson.save');
    Route::post('/schedule/lesson/time_modify', 'Teacher\\ScheduleController@lessonTimeModify')->name('teacher.schedule.lesson.time_modify');
    Route::post('/schedule/lesson/absent', 'Teacher\\ScheduleController@lessonAbsent')->name('teacher.schedule.lesson.absent');
});