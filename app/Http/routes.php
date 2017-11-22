<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/', 'GeneralController@index');
Route::get('login', 'AuthController@getLogin');
Route::get('logout', 'AuthController@logout');
Route::post('login', 'AuthController@postLogin');

Route::get('time', 'GeneralController@time');
Route::post( 'adduserfirst', 'GeneralController@addUserFirst');

//menggunakan auth dulu ini
Route::group(['middleware' => 'auth'], function (){
    Route::get('dashboard', 'DashboardController@index');
    Route::post( 'adddpt', 'DashboardController@addDpt');
    Route::post( 'adduser', 'DashboardController@addUser');
    Route::post( 'search', 'OperatorController@cariDpt');
    Route::post( 'generate', 'OperatorController@genToken');
    Route::post( 'addpresbem', 'CandidateController@addPresBem');
    Route::post( 'adddpm', 'CandidateController@addDpm');
});
//gawe android
Route::post('dev-login', 'AndroidController@login');
Route::post('dev-votebem', 'AndroidController@voteBem');
Route::post('dev-votedpm', 'AndroidController@voteDpm');
Route::post('dev-logout', 'AndroidController@logout');

//gawe device
Route::get('dev-connect', 'DeviceController@connect');
Route::get('dev-check/{host}', 'DeviceController@check');
Route::get('room-check/{host}', 'DeviceController@checkBilik');

//gawe result
Route::get('result', 'ResultController@hasil');
Route::post('result/login', 'ResultController@resLogin');
Route::get('result/logout', 'ResultController@logout');