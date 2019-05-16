<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class PagesController extends Controller
{
    public function index(){
    	return view('pages.index');
    }

    public function home(){

        if(Session::has('user_id'))
          {
            return view('pages.home');
            }
            else{
            return view('pages.index');
           }
    }

    public function vehiclepass(){
        
        return view('pages.vehicle_pass');

    }

    public function tripList(){
        return view('pages.listdelivery');
    }

     public function create_schedule(){
        return view('pages.create_schedule');
    }

   
}
