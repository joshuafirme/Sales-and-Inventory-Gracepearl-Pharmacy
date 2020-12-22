<?php

namespace App\Http\Controllers\Maintenance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\ShippingAddressMaintenance;
use Illuminate\Support\Facades\Input;

class ShippingAddressCtr extends Controller
{
   private $tbl_shipping = "tblshipping_add";

   public function index(){

        $s = DB::table($this->tbl_shipping)
        ->paginate(10);

        return view('maintenance/shipping/shipping_add', ['shippingAdd' => $s]);
   }
}
