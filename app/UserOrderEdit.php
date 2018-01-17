<?php
/**
 * Created by IntelliJ IDEA.
 * User: X.P
 * Date: 1/16/2018
 * Time: 9:22 PM
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

class UserOrderEdit extends Model{
    protected $table = 'userorder';
    public $timestamps = false;
    public $guarded = [];
    protected function getDataFormat(){
        return 'U';
    }

    protected function asDateTime($value)
    {
        return $value;
    }

    public function status($ind = null){
        $arr = [
            0 => '未提货',
            1 => '已提货，未付款',
            2 => '已付款',
            3 => '取消订单'
        ];
        if($ind !== null){
            return array_key_exists($ind,$arr)?$arr[$ind]:'未知';
        }
        return $arr;
    }
}