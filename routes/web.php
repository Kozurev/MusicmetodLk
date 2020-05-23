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

Route::get('/login', 'LoginController@index')->name('login.index');
Route::post('/login/auth', 'LoginController@auth')->name('login.make');
Route::get('/logout', 'LoginController@logout')->name('login.logout');

Route::get('/balance', 'BalanceController@index')->name('balance.index');

Route::get('/rates', 'RatesController@index')->name('rates.index');
Route::get('/rates/buy/{id}', 'RatesController@buyPrepare')->name('rates.buy.prepare');
Route::post('/rates/buy/{id}', 'RatesController@buyExecute')->name('rate.buy.execute');

Route::get('/faq', 'FaqController@index')->name('faq.index');
Route::get('/faq/feedback', 'FaqController@feedback')->name('faq.feedback');