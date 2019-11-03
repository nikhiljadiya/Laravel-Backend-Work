<?php

use Illuminate\Http\Request;

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

/*
| Authentication
*/

Route::any('login', 'API\AuthAPIController@login');
Route::any('logout', 'API\AuthAPIController@logout');

/*
| Timer Data
*/

Route::any('timer-data/get', 'API\TimerDataAPIController@getTimerData');
Route::any('timer-data/save', 'API\TimerDataAPIController@saveTimerData');