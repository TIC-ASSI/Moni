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

// Route::post('/data',function(Request $request){
//     $attributes = $request->validate([
//         'server' => 'required',
//         'token' => 'required',
//         'data' => 'required'
//     ]);
//     return \App\User::first()->data()->create($attributes);
// });

Route::post('/data', 'DataController@data');
