<?php

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

Route::post('login', 'AuthController@login');

Route::group(['middleware' => ['jwt.auth']], function () {
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
});

Route::get('sedes/{id}', 'SedesController@get');
Route::post('asignatura', 'AsignaturaController@get');

Route::post('notas', 'AsignaturaController@storeNote');

Route::get('anioLectivo/{id}', 'AnioLectivoController@get');
