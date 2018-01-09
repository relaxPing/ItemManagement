<?php
/**
 * Created by IntelliJ IDEA.
 * User: X.P
 * Date: 1/1/2018
 * Time: 12:02 PM
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

class UserOrder extends Model{
    protected $table = 'userorder';
    public $timestamps = true;
    public $guarded = [];
    protected function getDataFormat(){
        return 'U';
    }

    protected function asDateTime($value)
    {
        return $value;
    }
}