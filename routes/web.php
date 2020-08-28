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

Route::any('/' , 'api\NewsController@index' );

Route::any('/testa','api\LoginController@test');

Route::any('/lunbo','api\LunBoController@lunbo');

<<<<<<< HEAD
Route::any('/news_details' , 'api\NewsController@news_details' );
=======
Route::any('/details','api\DetailController@detail');

>>>>>>> ba6276e94024f683fae7ab12a4853988cc5785ca
