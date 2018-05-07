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
Route::post('/address','AddressController@address');
Route::get('/addlist','AddressController@addlist');
Route::get('/editress','AddressController@editress');
Route::post('/edit','AddressController@edit');
Route::post('/forget','ForgetController@forget');
Route::post('/change','ChangeController@change');
//Route::get('/change','ChangeController@change');
Route::post('/addcart','AddcartController@addcart');
Route::get('/cart','AddcartController@cart');
Route::post('/addoreder','AddorederController@addoreder');
Route::get('/order','AddorederController@order');
Route::get('/orderList','AddorederController@orderList');
Route::post('/pay','PayController@pay');
