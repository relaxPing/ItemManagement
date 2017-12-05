<?php
/**
 * Created by IntelliJ IDEA.
 * User: X.P
 * Date: 12/5/2017
 * Time: 12:50 PM
 */
namespace App\Http\Controllers;

class loginController extends Controller{
    public function login(){
        return view('login');
    }
}