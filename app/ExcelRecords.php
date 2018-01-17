<?php
/**
 * Created by IntelliJ IDEA.
 * User: X.P
 * Date: 1/15/2018
 * Time: 3:05 PM
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

class ExcelRecords extends Model{
    protected $table = 'records';
    public $timestamps = false;
    public $guarded = [];
}