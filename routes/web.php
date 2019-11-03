<?php

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

Auth::routes();
Route::get('/', 'HomeController@index')->name('home');
Route::any('ajax-refresh-timer-data', 'HomeController@refreshTimerData')->name('timer_data.refresh');

/*
| Users
*/
Route::any('users/search', 'UserController@search')->name('users.search');
Route::any('users/multi-delete', 'UserController@multiDelete')->name('users.multi_delete');
Route::any('users/change-status', 'UserController@changeStatus')->name('users.change_status');
Route::any('users/change-login-status', 'UserController@changeLoginStatus')->name('users.change_login_status');
Route::resource('users', 'UserController');

/*
| Cities
*/
Route::any('cities/search', 'CityController@search')->name('cities.search');
Route::any('cities/multi-delete', 'CityController@multiDelete')->name('cities.multi_delete');
Route::resource('cities', 'CityController');

/*
| Timer Data
*/
/*Route::any('timer-data', 'TimerDataController@index')->name('timer_data.index');*/

/*Route::get('run-cmd', function () {
	//Artisan::call('config:clear');
	//Artisan::call('cache:clear');
	//Artisan::call('route:clear');
	//Artisan::call('view:clear');
	//Artisan::call('migrate');
	//Artisan::call('make:auth');
	//Artisan::call('make:controller', ['name' => 'DemoController']);
	//dd(Artisan::output());
});*/