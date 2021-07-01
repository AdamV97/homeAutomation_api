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

Route::middleware('auth:api')->group(function () {
    Route::get('allData', 'App\Http\Controllers\dataController@allData');
    Route::get('deviceStatus', 'App\Http\Controllers\deviceController@deviceStatus');
    Route::get('logout', 'App\Http\Controllers\userController@logout');
});

Route::get('avgDayData', 'App\Http\Controllers\dataController@avgDayData');
Route::get('lastData', 'App\Http\Controllers\dataController@lastData');

// ************************************************
Route::get('alarms', 'App\Http\Controllers\alarmController@getAlarms');
Route::post('checkAlarm', 'App\Http\Controllers\alarmController@checkAlarm');
Route::post('setAlarm', 'App\Http\Controllers\alarmController@setAlarm');

// ************************************************
Route::post('saveToken', 'App\Http\Controllers\installationTokenController@saveToken');

// ************************************************
Route::get('localWeather', 'App\Http\Controllers\weatherDataController@checkForUpdate');

Route::post('login', 'App\Http\Controllers\userController@login');