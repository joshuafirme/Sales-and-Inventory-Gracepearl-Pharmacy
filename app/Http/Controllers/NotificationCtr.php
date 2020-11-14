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

    public function index()
    {
        $near_expiry_product = $this->getAllNearExpiry(); 
        $expired_product = $this->getAllExpired(); 
        $reorder_product = $this->getAllReOrder(); 

        //count 
        $near_expiry_count = $near_expiry_product->count();
        $expired_count = $expired_product->count();
        $reorder_count = $reorder_product->count();

        return view('/inventory/notification',
            [
            'nearExpiryProduct' => $near_expiry_product,
            'expiredProduct' => $expired_product,
            'reorderProduct' => $reorder_product,
            'expiredCount' => $expired_count, 
            'expiryCount' => $near_expiry_count, 
            'reorderCount' => $reorder_count,             
            ]);
    }

    public function getAllNearExpiry()
    {
        $product = DB::table($this->table_prod)
        ->select("tblproduct.*", DB::raw('CONCAT(tblproduct._prefix, tblproduct.id) AS productCode,  unit, category_name'))
        ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
        ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
        ->leftJoin($this->table_unit, $this->table_unit . '.id', '=', $this->table_prod . '.unitID')
        ->whereRaw('tblproduct.exp_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 3 MONTH)')
        ->paginate(10);

        return $product;
    }


    public function getAllExpired()
    {
        $product = DB::table($this->table_prod)
        ->select("tblproduct.*", DB::raw('CONCAT(tblproduct._prefix, tblproduct.id) AS productCode, unit, category_name'))
        ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
        ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
        ->leftJoin($this->table_unit, $this->table_unit . '.id', '=', $this->table_prod . '.unitID')
        ->whereRaw('tblproduct.exp_date <= CURDATE()')
        ->paginate(10);

        return $product;
    }

    public function getAllReOrder()
    {
        $product = DB::table($this->table_prod)
        ->select("tblproduct.*", DB::raw('CONCAT(tblproduct._prefix, tblproduct.id) AS productCode, unit, category_name'))
        ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
        ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
        ->leftJoin($this->table_unit, $this->table_unit . '.id', '=', $this->table_prod . '.unitID')
        ->whereRaw('tblproduct.qty <= tblproduct.re_order')
        ->paginate(10);

        return $product;
    }

}