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

Route::get('/', function () {
    return view('welcome');
});

//注册模块(接口)
Route::prefix('reg')->group(function(){
    //图片验证码
    Route::any('imageCode','Api\RegisterController@imageCode');
    //获取图片验证码路径
    Route::any('getImgCodeUrl','Api\RegisterController@getImgCodeUrl');
});
