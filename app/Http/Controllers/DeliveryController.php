<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CustomerTransaction;
use App\codTransaction;
use App\DriverHelper;
use App\CusttrandataModel;
use App\tempschedModel;
use App\tranMainModel;
use Illuminate\Support\Facades\DB;
use DataTables;
use PDF;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   

    public function savetoTemp(Request $request){
        $date_create = date('Y-m-d H:i:s');

        $tmpsched = new tempschedModel();

        try{
                     if (tempschedModel::where('dr_no', '=', $request->input('dr'))->exists()) {

                             return  \Response(['msg'=>'Already recorded']);

                        }else{

                            $tmpsched->outlet = $request->input('outlet');
                            $tmpsched->address = $request->input('Address');
                            $tmpsched->amount = $request->input('amount');
                            $tmpsched->brand = $request->input('Brand');
                            
                            if($request->input('trantype') == 0){

                                $tmpsched->dr_no = $request->input('dr');

                            }else{

                                $tmpsched->si_no = $request->input('dr');
                            }
                            
                            $tmpsched->category = $request->input('categ');
                            $tmpsched->no_of_box = $request->input('boxno');
                            $tmpsched->series = $request->input('series');
                            $tmpsched->date_created =  $date_create;
                            $tmpsched->form_no = $request->input('frmno');

                            if($request->input('mode') == 'E'){

                                $tmpsched->is_printed = 'Y';
                            }

                            $tmpsched->save();

                            return  \Response(['msg'=>'Record saved.']);
                        }


            }catch(\Exception $e){
                return $e;
            }
    }

    public function savetoMain(Request $request){

        $date_create = date('Y-m-d H:i:s');

        $main = new tranMainModel();


        try {

                 if (tranMainModel::where('form_series_no', '=', $request->input('frmno'))->exists()) {

                        return  \Response(['msg'=>'Already recorded']);

                    }else{

                        $main->form_series_no = $request->input('frmno');
                        $main->driver = $request->input('driver');
                        $main->plate_no = $request->input('plateno');
                        $main->helper = $request->input('helper');
                        $main->contact = $request->input('contact');
                        $main->date_delivery = $request->input('deliverydate');
                        $main->maker = $request->input('preparedby');
                        $main->area = $request->input('area');
                        $main->time = $request->input('time');
                        $main->date_created =  $date_create;
                        $main->save();

                        return  \Response(['msg'=>'Record saved.']);
                    }

            }catch(\Exception $e){
                return $e;
            }
            
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        try{
 
               
                $payment = CustomerTransaction::where('cust_tran_head.DOC_NO',$id)
                                        ->where('cust_tran_head.CLEARED_PAYMENT', 'N')
                                        ->leftJoin('cust_tran_data', 'cust_tran_head.TRAN_NO', '=', 'cust_tran_data.HEAD_TRAN_NO')
                                        ->leftJoin('mnt_products', 'mnt_products.PROD_SYS_CODE', '=', 'cust_tran_data.PROD_SYS_CODE')
                                        ->Select('cust_tran_head.TRAN_NO','cust_tran_head.CONTACT_CODE','cust_tran_head.TRAN_TYPE','cust_tran_head.TRAN_DATE',
                                            'cust_tran_head.ADDRESS1','cust_tran_head.AMOUNT_NET','mnt_products.PROD_BRD_CODE')->get();

               return \Response::json($payment);

            }catch(\Exception $e){
                return $e;
            }
        
    }


     public function displayEntry(){

        $date_create = date('Y-m-d');

        try{
                $details = tempschedModel::select('id','outlet','address','brand','dr_no','si_no','no_of_box',
                                                    'category','amount','series')
                                                ->where('is_printed','N')
                                                ->get();
              
                return (DataTables::of($details)->addColumn('action', function($details){
                                    
                                     return '<button class="btn btn-danger" title="Remove Details" id="'.$details->id.'" onclick="delDetails(this.id)" style="cursor: pointer;" ><i class="fa fa-trash"></i></button>';
                                            
                                })->make(true));

            }catch(\Exception $e){
                return $e;
            }
            
    }

    public function getDriver(){

         try{

                $driver = DriverHelper::select('id','name','Plate_no','Contact')->whereIn('category',array('D','R'))->get();
                return \Response::json($driver);
                
            }catch(\Exception $e){
                    return $e;
            }

    }

     public function getHelper(){

         try{

                $driver = DriverHelper::select('id','name','Contact')->where('category','H')->get();
                return \Response::json($driver);
                
            }catch(\Exception $e){
                    return $e;
            }

    }

    public function getLastSeq(){

        try{

                 $lastseq = tranMainModel::select('form_series_no')->orderBy('form_series_no', 'desc')->first();
                return \Response::json($lastseq);

            }catch(\Exception $e){
                    return $e;
            }
    }

    public function printTripSchedule($frm){

        try{
    
                  $details2 = tranMainModel::where('form_series_no', '=', $frm)->update(['is_printed' => 'Y']);

                  $details3 = tempschedModel::where('form_no', '=', $frm)->update(['is_printed' => 'Y']);


                  $details = tranMainModel::where('tbl_main.form_series_no', $frm)
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
                  return $pdf->stream('pages.printsched.pdf');

             }catch(\Exception $e){
                    return $e;
            }
      
    }

    public function cancelList($id){
        try{
                tempschedModel::destroy($id);
                return  \Response(['msg'=>'Record Deleted']);
                
            }catch(\Exception $e){
                return $e;
            }
    }

    public function tripList($date){

        $dates = explode("*",$date);
        $min = $dates[0];
        $max = $dates[1];

        try{

                if($min == '' && $max == ''){
                        $details = DB::table('tbl_main')
                                ->leftJoin('tbl_driver_helper as a', 'a.id', '=', 'tbl_main.driver')
                                ->leftJoin('tbl_driver_helper as b', 'b.id', '=', 'tbl_main.helper')
                                ->select('tbl_main.id','tbl_main.form_series_no','tbl_main.plate_no','a.name as driver','b.name as helper','tbl_main.contact','tbl_main.area','tbl_main.time','tbl_main.date_delivery'
                                )->get();
                        return (DataTables::of($details)->addColumn('action', function($details){
                                                   
                                                        return '<button class="btn btn-primary" title="Reprint Details" id="'.$details->id.'!'.$details->form_series_no.'" onclick="rePrint(this.id)" style="cursor: pointer;" ><i class="fa fa-print"></i></button>
                                                        <button class="btn btn-primary" title="Add Details" id="'.$details->form_series_no.'" onclick="addDetails(this.id)" style="cursor: pointer;" data-toggle="modal" data-target="#modModal"><i class="fa fa-plus"></i></button>
                                                        <button class="btn btn-primary" title="View Details" id="'.$details->form_series_no.'" onclick="viewDetails(this.id)" style="cursor: pointer;" data-toggle="modal" data-target="#viewModal"><i class="fas fa-eye"></i></button>';


                                                })->make(true));
                }else{
                         $details = DB::table('tbl_main')
                                ->leftJoin('tbl_driver_helper as a', 'a.id', '=', 'tbl_main.driver')
                                ->leftJoin('tbl_driver_helper as b', 'b.id', '=', 'tbl_main.helper')
                                ->select('tbl_main.id','tbl_main.form_series_no','tbl_main.plate_no','a.name as driver','b.name as helper','tbl_main.contact','tbl_main.area','tbl_main.time','tbl_main.date_delivery')
                                ->whereRaw("DATE(tbl_main.date_delivery) >= '".$min."' AND DATE(tbl_main.date_delivery) <= '".$max."' ")
                                ->get();
                        return (DataTables::of($details)->addColumn('action', function($details){
                                                   
                                                        return '<button class="btn btn-primary" title="Reprint Details" id="'.$details->id.'!'.$details->form_series_no.'" onclick="rePrint(this.id)" style="cursor: pointer;" ><i class="fa fa-print"></i></button>
                                                        <button class="btn btn-primary" title="Add Details" id="'.$details->form_series_no.'" onclick="addDetails(this.id)" style="cursor: pointer;" data-toggle="modal" data-target="#modModal"><i class="fa fa-plus"></i></button>
                                                        <button class="btn btn-primary" title="View Details" id="'.$details->form_series_no.'" onclick="viewDetails(this.id)" style="cursor: pointer;" data-toggle="modal" data-target="#viewModal"><i class="fas fa-eye"></i></button>';

                                                })->make(true));
                }

            }catch(\Exception $e){
                return $e;
            }
    }

    public function redisplayEntry($formno){

        try{
                $details = tempschedModel::select('id','outlet','address','brand','dr_no','si_no','no_of_box',
                                                    'category','amount','series')
                                                ->where('is_printed','Y')
                                                ->where('form_no', $formno)
                                                ->get();
              
                return \Response::json($details);

            }catch(\Exception $e){
                return $e;
            }
            
    }

     public function adon_filter(){

        
        try{

              
                $details = DB::table('tbl_main')
                        ->leftJoin('temp_sched as a', 'a.form_no', '=', 'tbl_main.form_series_no')
                        ->select('a.form_no','a.dr_no','a.si_no','a.series','tbl_main.date_delivery')->get();
                return (DataTables::of($details)->make(true));
                
            }catch(\Exception $e){
                return $e;
            }
    }
}
