<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class driverScheduleModel extends Model
{
    //
    protected $connection = 'mysql';
    public $timestamps = false;
    protected $table = 'daily_route_list';

   /* public function driverRoutes(){

    	return $this->hasOne(DriverHelper::class);
    }*/

}
