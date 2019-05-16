<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DriverHelper extends Model
{
   
    protected $connection = 'mysql';
    public $timestamps = false;
    protected $table = 'tbl_driver_helper';
}
