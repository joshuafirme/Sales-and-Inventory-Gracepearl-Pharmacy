<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StockEntryCtr extends Controller
{
    public function index(){
        return  view('/inventory/stockentry', ['getCurrentDate' => date('yy-m-d')]);
    }

}
