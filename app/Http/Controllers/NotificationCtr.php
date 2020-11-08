<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\ProductMaintenance;

class NotificationCtr extends Controller
{
    private $table_prod = "tblproduct";
    private $table_cat = "tblcategory";
    private $table_suplr = "tblsupplier";
    private $table_unit = "tblunit";

    public function index(Request $request)
    {
        $near_expiry_product = $this->getAllNearExpiry(); 
        
        if(request()->ajax())
        {     
                return datatables()->of($near_expiry_product)
                ->make(true);
           
        }
        return view('/inventory/notification');
    }

    public function expiredProduct(Request $request)
    {

        $expired_product = $this->getAllExpired(); 
        
        if(request()->ajax())
        {     
                return datatables()->of($expired_product)
                ->make(true);
           
        }
        return view('/inventory/notification');
    }

    public function getAllNearExpiry()
    {
        $product = DB::table($this->table_prod)
        ->select("tblproduct.*", DB::raw('CONCAT(tblproduct._prefix, tblproduct.id) AS productCode, unit, category_name'))
        ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
        ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
        ->leftJoin($this->table_unit, $this->table_unit . '.id', '=', $this->table_prod . '.unitID')
        ->whereRaw('tblproduct.exp_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 3 MONTH)')
        ->get();

        return $product;
    }

    public function getAllExpired()
    {
        $product = DB::table($this->table_prod)
        ->select("tblproduct.*", DB::raw('CONCAT(tblproduct._prefix, tblproduct.id) AS productCode, unit, category_name'))
        ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
        ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
        ->leftJoin($this->table_unit, $this->table_unit . '.id', '=', $this->table_prod . '.unitID')
        ->whereRaw('tblproduct.exp_date < CURDATE()')
        ->get();

        return $product;
    }

}
