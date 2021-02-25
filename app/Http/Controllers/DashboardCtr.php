<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Classes\UserAccessRights;
use App\Classes\Date;
use Auth;

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
            'walkinSales' => $this->getWalkinSales(),
            'onlineSales' => $this->getOnlineSales(),
            'registeredCustomer' => $this->getRegisteredCustomer()
        ]);
    }

    public function getOrders(){
        return DB::table('tblonline_order')
                ->whereDate('created_at', date('Y-m-d'))
                ->count();
    }

    public function getWalkinSales(){
        return DB::table('tblsales')
                ->whereBetween('date', [date('Y-m-d', strtotime("-3 months")), date('Y-m-d')])
                ->where('order_from', 'Walk-in')
                ->sum('amount');
    }

    public function getOnlineSales(){
        return DB::table('tblsales')
                ->whereBetween('date', [date('Y-m-d', strtotime("-3 months")), date('Y-m-d')])
                ->where('order_from', 'Online')
                ->sum('amount');
    }

    public function getRegisteredCustomer(){
        return DB::table('tblcustomer_account')->count();
    }


}
