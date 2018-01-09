<?php
/**
 * Created by IntelliJ IDEA.
 * User: X.P
 * Date: 1/8/2018
 * Time: 2:46 PM
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

//进货记录的模型
class Adds extends Model{
    protected $table = 'record_add';
    public $guarded = [];
    public $timestamps = true;
    protected $dateFormat = 'U';
    protected function getDataFormat(){
        return 'U';
    }
    public function fromDateTime($value) {
        return $value;
    }
    protected function asDateTime($value)
    {
        return $value;
    }
}