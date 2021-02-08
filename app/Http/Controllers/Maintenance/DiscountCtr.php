<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Discount;
use App\Classes\UserAccessRights;

class DiscountCtr extends Controller
{
    private $module = "Maintenance";

    public function index()
    {
        $rights = new UserAccessRights;

        if(!($rights->isUserAuthorize($this->module)))
        {
            return view('/layouts.not_auth');
        }

        $pwd_discount = $this->getPWDDiscount();
        $sc_discount = $this->getSeniorCitizenDiscount();

        return view('/maintenance/discount/discount', [
            'pwd_discount' => $pwd_discount,
            'sc_discount' => $sc_discount,
            ]);
    }

    public function getPWDDiscount(){
        $discount = DB::table('tbldiscount')->value('pwd_discount');
        return $discount;
    }

    public function getSeniorCitizenDiscount(){
        $discount = DB::table('tbldiscount')->value('sc_discount');
        return $discount;
    }

    public function activate(Request $request){

        $sc_discount = $request->input('sc-discount');
        $pwd_discount = $request->input('pwd-discount');

        DB::table('tbldiscount')
        ->update([
            'sc_discount' => $sc_discount,
            'pwd_discount' => $pwd_discount
            ]);

        return redirect('/maintenance/discount')->with('success', 'Discount Activated');
    }
}
