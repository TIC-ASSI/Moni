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

Route::post('/login', 'MoniController@login');
Route::post('/register', 'MoniController@register');

Route::middleware('auth:api')->group(function () {
    Route::post('/servers', 'MoniController@servers');
    Route::post('/servers/{server}', 'MoniController@server');
    Route::post('/data', 'MoniController@data');
});