<?php
/**
 * Created by IntelliJ IDEA.
 * User: X.P
 * Date: 11/29/2017
 * Time: 4:13 PM
 */
namespace App;
use Illuminate\Database\Eloquent\Model;

class Items extends Model{
    protected $table = 'items';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;
    //public $fillable =['name','price','code','quantity','id','priceComment'];
    public $guarded = [];
    protected function getDataFormat(){
        return time();
    }

    protected function asDateTime($value)
    {
        return $value;
    }
}