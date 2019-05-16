<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RouteList;
use Illuminate\Support\Facades\DB;
use App\driverScheduleModel;
use DataTables;

class SheduleRouteController extends Controller
{
    //
    public function getroute(){

         try{

                $driver = RouteList::select('id','route')->get();
                return \Response::json($driver);
                
            }catch(\Exception $e){
                    return $e;
            }

    }

    public function displaySchedule(){

    	 try{
                 $details = DB::table('daily_route_list as aa')
                                ->leftJoin('tbl_driver_helper as a', 'a.id', '=', 'aa.Driver')
                                ->leftJoin('tbl_driver_helper as b', 'b.id', '=', 'aa.Helper')
                                ->select('aa.id','a.Plate_no','a.name as driver','b.name as helper','aa.route','aa.time','aa.date_deliver','aa.date_created'
                                )->get();
                        return (DataTables::of($details)->addColumn('action', function($details){
                                                   
                                                        return '<button class="btn btn-danger" title="Remove Details" id="'.$details->id.'" onclick="removeDetails(this.id)" style="cursor: pointer;" ><i class="fa fa-trash"></i></button>';
                                                })->make(true));

            }catch(\Exception $e){
                return $e;
            }

    }

    public function saveTrip(Request $request){

        $date_create = date('Y-m-d H:i:s');

         try{

                    $checkExist = driverScheduleModel::where('Driver', '=', $request->input('driver'))
                                                ->where('Helper', '=', $request->input('helper'))
                                                ->where('date_deliver', '=', $request->input('deliverydate'))
                                                ->get();
                    if(count($checkExist) > 0){
                        return  \Response(['msg'=>'Record exists.']);
                    }else{

                       // return $request->all();
                        $sched = new driverScheduleModel();

                        $sched->Driver = $request->input('driver');
                        $sched->Helper = $request->input('helper');
                        $sched->route = $request->input('area');
                        $sched->time = $request->input('time');
                        $sched->date_deliver = $request->input('deliverydate');
                        $sched->date_created = $date_create;
                        $sched->save();

                        return  \Response(['msg'=>'Route Destination saved.']);
                    }

             }catch(\Exception $e){
                return $e;
         }

    }

    public function removeTrip($id){
        try{
                driverScheduleModel::destroy($id);
                return  \Response(['msg'=>'Record Deleted']);
                
            }catch(\Exception $e){
                return $e;
            }
    }

    public function printDriverSchedule(){

        try{

            /*$details = tranMainModel::where('tbl_main.form_series_no', $frm)
                                    ->join('temp_sched as c', 'c.form_no', '=', 'tbl_main.form_series_no')
                                    ->leftJoin('tbl_driver_helper as a', 'a.id', '=', 'tbl_main.driver')
                                    ->leftJoin('tbl_driver_helper as b', 'b.id', '=', 'tbl_main.helper')
                                    ->join(DB::raw("(SELECT x.form_no,FORMAT(sum(x.amount),2) as tot_amnt from temp_sched  x GROUP BY x.form_no) AS TOT"),function($join){
                                            $join->on("TOT.form_no","=","tbl_main.form_series_no");
                                      })
                                    ->join(DB::raw("(SELECT y.form_no,sum(y.no_of_box) as tot_box from temp_sched  y GROUP BY y.form_no) AS TOT_BOX"),function($join){
                                            $join->on("TOT_BOX.form_no","=","tbl_main.form_series_no");
                                      })
                                    ->select('tbl_main.form_series_no','tbl_main.plate_no','a.name as driver','b.name as helper','tbl_main.contact','tbl_main.area','tbl_main.time','tbl_main.date_delivery','c.outlet','c.address','c.brand','c.dr_no','c.si_no','c.no_of_box','c.category','c.amount','c.series','TOT.tot_amnt','TOT_BOX.tot_box'
                                    )->get();
                   
                          
                  $pdf = PDF::loadView('pages.printsched',['details'=> $details])->setPaper('legal', 'landscape')->setWarnings(false)->save('printsched.pdf');
                  return $pdf->stream('pages.printsched.pdf');*/

        }catch(\Exception $e){
            return $e;
        }
    }

}
