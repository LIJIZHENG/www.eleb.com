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
Route::get('/goodsnews','ApiController@goodsnews');
Route::get('/goodsaccounts','ApiController@goodsaccounts');
Route::get('/sms','SmsController@sms');
Route::post('/regist','RegistController@store');
Route::post('/login','RegistController@check');
