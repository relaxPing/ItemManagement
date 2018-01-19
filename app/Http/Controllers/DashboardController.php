<?php
/**
 * Created by IntelliJ IDEA.
 * User: X.P
 * Date: 12/28/2017
 * Time: 11:51 PM
 */
namespace App\Http\Controllers;
use App\UserOrder;
use Session;
class DashboardController extends Controller{
    public function dashboard(){
        //后台下单查询 的session (itemsController)
        if(Session::has('name')){
            Session::forget('name');
        }
        if(Session::has('num')){
            Session::forget('num');
        }
        if(Session::has('customer')){
            Session::forget('customer');
        }
        if(Session::has('isPaid')){
            Session::forget('isPaid');
        }
        if(Session::has('date')){
            Session::forget('date');
        }
        //用户自己下单列表查询的session (UserOrderController)
        if(Session::has('username')){
            Session::forget('username');
        }
        if(Session::has('itemname')){
            Session::forget('itemname');
        }
        if(Session::has('userid')){
            Session::forget('userid');
        }
        if(Session::has('status')){
            Session::forget('status');
        }
        $remind = UserOrder::where('status',0)->count();
        return view('welcome',[
            'remind'=>$remind
        ]);
    }
}