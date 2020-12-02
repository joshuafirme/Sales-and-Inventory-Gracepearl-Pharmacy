<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Input;
use App\ProductMaintenance;
use App\SupplierDelivery;

class SupplierDeliveryCtr extends Controller
{
    public function index()
    { 
        return view('inventory/supplier_delivery');
    }

}
