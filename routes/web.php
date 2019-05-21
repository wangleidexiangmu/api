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
Route::get('test','api\ApiController@test');
Route::get('user','api\ApiController@user')->middleware('reques');
//post测试
Route::post('/testform','api\ApiController@testform');
Route::post('testapp','api\ApiController@testapp');
Route::post('testraw','api\ApiController@testraw');
//中间件测试
//Route::get('reque','api\ApiController@reque')->middleware('reques');
//注册
Route::post('/reg','User\UserController@reg');
//登录
Route::post('/login','User\UserController@login');
//接口
Route::get('/conter','User\UserController@conter')->middleware('reques','conter');
Route::resource('/goods', GoodsController::class);//资源注册
Route::get('/reg','Test\RegController@reg');//注册
Route::post('/regest','Test\RegController@regest');//注册
Route::post('/upload','Test\RegController@upload');//上传

Route::get('/getToken','Test\RegController@getToken');//获取token
Route::get('/getid','Test\RegController@getid')->middleware('number');//获取token
Route::get('/getUA','Test\RegController@getUA')->middleware('number');//获取token
Route::get('/getuser','Test\RegController@getuser')->middleware('number');//获取token
Route::get('/getall','Test\RegController@getall');//获取token
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
