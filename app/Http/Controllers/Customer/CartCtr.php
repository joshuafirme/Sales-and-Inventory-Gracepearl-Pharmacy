<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Input;
use App\ProductMaintenance;

class CartCtr extends Controller
{
    public function index(){
        return view('/customer/cart');
      }
}
