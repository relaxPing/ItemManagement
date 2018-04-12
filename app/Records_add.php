<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Records_add extends Model
{
    protected $table = 'record_add';
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
