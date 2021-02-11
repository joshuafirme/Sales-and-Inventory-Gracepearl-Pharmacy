<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Classes\UserAccessRights;
use App\Classes\Date;

class DashboardCtr extends Controller
{
    private $table_sales = "tblsales";
    private $table_prod = "tblproduct";
    private $table_cat = "tblcategory";
    private $table_suplr = "tblsupplier";
    private $table_unit = "tblunit";
    private $module = "Maintenance";

    public function index(){
        if(session()->get('is-login') !== 'yes'){
   
            return redirect()->to('/admin-login')->send();
         }

        return view('/dashboard',[
            'newOrders' => $this->getOrders(),
            'currentMonthSales' => $this->getCurrentMonthSales(),
            'registeredCustomer' => $this->getRegisteredCustomer()
        ]);
    }

    public function getOrders(){
        return DB::table('tblonline_order')
                ->whereDate('created_at', date('Y-m-d'))
                ->count();
    }

    public function getCurrentMonthSales(){
        return DB::table('tblsales')
                ->whereBetween('date', [date('Y-m-d', strtotime("-3 months")), date('Y-m-d')])
                ->sum('amount');
    }

    public function getRegisteredCustomer(){
        return DB::table('tblcustomer_account')->count();
    }


}
