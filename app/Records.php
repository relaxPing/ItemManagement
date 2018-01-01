<?php
/**
 * Created by IntelliJ IDEA.
 * User: X.P
 * Date: 11/29/2017
 * Time: 4:13 PM
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

class Records extends Model{
    protected $table = 'records';
    public $timestamps = true;
    public $guarded = [];
    protected function getDataFormat(){
        return time();
    }

    protected function asDateTime($value)
    {
        return $value;
    }
}