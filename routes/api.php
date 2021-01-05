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

Route::get('lastData', 'App\Http\Controllers\dataController@lastData');
Route::get('allData', 'App\Http\Controllers\dataController@allData');
Route::get('devices', 'App\Http\Controllers\deviceController@allDevices');