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
Route::get('dashboard', ['uses'=>'DashboardController@dashboard']);
//商品展示页面
Route::any('items',['uses'=>'ItemsController@items']);
Route::any('record_take',['uses'=>'ItemsController@record_take']);

Route::group(['middleware'=>'web'],function (){
    Route::any('create',['uses'=>'ItemsController@create']);
    Route::any('add',['uses'=>'ItemsController@add']);
    Route::any('take',['uses'=>'ItemsController@take']);
    //修改商品信息
    Route::any('modify/{code}',['uses'=>'ItemsController@modify']);
    //修改提取记录
    Route::any('modifyRecord/{id}',['uses'=>'RecordsController@modifyRecord']);
});

Route::any('login',['uses'=>'loginController@login']);




//这个用于给用户展示商品列表
Route::any('itemList',['uses'=>'ItemsController@itemList']);