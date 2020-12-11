<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Discount;

class DiscountCtr extends Controller
{
    public function index(){

        $discount = $this->discount();
        return view('/maintenance/discount/discount', ['discount' => $discount]);
    }

    public function discount(){
        $discount = DB::table('tbldiscount')->first();
        return $discount;
    }

    public function getDiscount(){
        $discount = DB::table('tbldiscount')->get();
        return $discount;
    }

    public function activate(Request $request){

        $discount = $request->input('discount');

        DB::update('UPDATE tbldiscount SET discount = ?',
        [$discount]);
        return redirect('/maintenance/discount')->with('success', 'Discount Activated');
    }
}
