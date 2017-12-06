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
Route::get('dashboard', function () {
    return view('welcome');
});

Route::any('items',['uses'=>'ItemsController@items']);
Route::any('record_take',['uses'=>'ItemsController@record_take']);

Route::group(['middleware'=>'web'],function (){
    Route::any('create',['uses'=>'ItemsController@create']);
    Route::any('add',['uses'=>'ItemsController@add']);
    Route::any('take',['uses'=>'ItemsController@take']);
});

Route::any('login',['uses'=>'loginController@login']);

//这个用于给用户展示商品列表
Route::any('itemList',['uses'=>'ItemsController@itemList']);