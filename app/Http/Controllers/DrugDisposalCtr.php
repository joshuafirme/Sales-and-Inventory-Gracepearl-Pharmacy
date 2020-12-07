<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DrugDisposalCtr extends Controller
{
    public function index(){
        return view('/inventory/drug_disposal');
    }
}
