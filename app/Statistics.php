<?php
/**
 * Created by IntelliJ IDEA.
 * User: X.P
 * Date: 1/8/2018
 * Time: 2:47 PM
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

//进货记录的模型
class Statistics extends Model{
    protected $table = 'statistics';
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