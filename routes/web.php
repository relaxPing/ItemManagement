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
    Route::any('modify/{id}',['uses'=>'ItemsController@modify']);
    //删除商品
    Route::any('itemDelete/{id}',['uses'=>'ItemsController@itemDelete']);
    //修改提取记录
    Route::any('modifyRecord/{id}',['uses'=>'RecordsController@modifyRecord']);
});

Route::any('login',['uses'=>'loginController@login']);




//这个用于给用户展示商品列表
Route::any('itemList',['uses'=>'ItemsController@itemList']);
//客户下单 下单页面和下单逻辑
/*Route::get('userOrder/{id}',['uses'=>'UserOrderController@userOrder']);*/
Route::post('orderLogic',['uses'=>'UserOrderController@orderLogic']);
//客户订单列表
Route::get('orderList',['uses'=>'UserOrderController@orderList']);
Route::post('orderListSearch',['uses'=>'UserOrderController@orderListSearch']);
//客户订单页面的修改
Route::resource('orderListEdit', 'UserOrderController', ['only' => [
    'update','show'
]]);

//用于更新数据库的页面
Route::get('temp',function (){
   return view('temp');
});

//财务统计
Route::get('statistics',['uses'=>'FinancialController@getStatistics']);
Route::post('statistics',['uses'=>'FinancialController@postStatistics']);

//导出excel
//1.导出后台提货的excel的页面
Route::get('backExcelPage',['uses'=>'ExcelController@backExcelPage']);
//2.导出后台提货的excel的逻辑
Route::post('backExcelLogic',['uses'=>'ExcelController@backExcelLogic']);
//3.导出客户下单的excel的页面
Route::get('orderExcelPage',['uses'=>'ExcelController@orderExcelPage']);
//4.导出客户下单excel的的逻辑
Route::post('orderExcelLogic',['uses'=>'ExcelController@orderExcelLogic']);



