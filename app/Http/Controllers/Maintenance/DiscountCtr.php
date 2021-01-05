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
            $rights->notAuthMessage();
        }

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
