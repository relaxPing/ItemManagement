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
        if(Session::has('name')){
            Session::forget('name');
        }
        if(Session::has('num')){
            Session::forget('num');
        }
        if(Session::has('customer')){
            Session::forget('customer');
        }
        $remind = UserOrder::where('status',0)->count();
        return view('welcome',[
            'remind'=>$remind
        ]);
    }
}