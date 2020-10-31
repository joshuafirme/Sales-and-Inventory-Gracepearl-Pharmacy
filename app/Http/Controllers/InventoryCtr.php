<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InventoryCtr extends Controller
{
    public function index(){
        return view('/inventory/stockadjustment');
    }
}
