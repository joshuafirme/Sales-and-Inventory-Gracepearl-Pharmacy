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
        $rights = new UserAccessRights;

        if(!($rights->isUserAuthorize($this->module)))
        {
            $rights->notAuthMessage();
        }

        $this->getSales();
        return view('/dashboard');
    }

    public function getSales(){

        $product = DB::table($this->table_sales)
        ->select('date','amount')
        ->whereBetween('date', ['2020-11-30', '2020-12-30'])
        ->groupBy('date','amount')
        ->get();
      
  
        return ;
      
            
      //   ->whereBetween('date', [$date_from, $date_to])
      //   ->where('category_name', $category)
      
     }
}
