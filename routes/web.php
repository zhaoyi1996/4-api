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



//发送验证码
Route::any('/vicode','api\LoginController@vicode');

Route::any('/login','api\LoginController@login');

Route::any('/test','api\LoginController@test');


//Route::get('/', function () {
//    return view('welcome');
//});

Route::any('/' , 'api\NewsController@index' );//新闻首页

Route::any('/testa','api\LoginController@test');

Route::any('/lunbo','api\LunBoController@lunbo');

Route::any('/details','api\DetailController@detail');//新闻详情

Route::any('/heat','api\NewsController@heat');//首页热点资讯

