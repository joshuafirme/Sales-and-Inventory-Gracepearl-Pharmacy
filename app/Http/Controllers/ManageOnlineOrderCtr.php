<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManageOnlineOrderCtr extends Controller
{
    public function index(){
 
          return view('/manageonlineorder/manage_online_order');
      }
}
