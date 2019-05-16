<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tempschedModel extends Model
{
    //
     protected $connection = 'mysql';
     public $timestamps = false;
     protected $table = 'temp_sched';
}
