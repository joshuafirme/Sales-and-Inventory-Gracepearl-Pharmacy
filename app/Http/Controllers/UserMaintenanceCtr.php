<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\UserMaintenance;
use Illuminate\Http\Request;
use Input;


class UserMaintenanceCtr extends Controller
{
    public function index(){

        return view('/maintenance/user/user');
    }

    public function store(Request $request){
      
        $user = new UserMaintenance;
        $user->_prefix = date('yy');
        $user->name = $request->input('employee_name');
        $user->position = $request->input('position');
        $user->username = $request->input('username');
        $user->password = $request->input('password'); 
    
        $modules = $request->all();
        $modules[] = $request->input('chk-module');

        $fusion = implode(" ", $modules[0]);
        
        $user->auth_modules = $fusion;
       
        $user->save();


        return redirect('/maintenance/user');
    }
}
