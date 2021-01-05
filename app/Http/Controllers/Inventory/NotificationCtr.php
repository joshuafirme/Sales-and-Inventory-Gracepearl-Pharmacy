<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\ProductMaintenance;
use App\Classes\UserAccessRights;

class NotificationCtr extends Controller
{
    private $table_prod = "tblproduct";
    private $table_cat = "tblcategory";
    private $table_suplr = "tblsupplier";
    private $module = "Inventory";

    public function index()
    {
        $rights = new UserAccessRights;

        if(!($rights->isUserAuthorize($this->module)))
        {
            $rights->notAuthMessage();
        }

        $suplr = DB::table($this->table_suplr)->get();

        $near_expiry_product = $this->getAllNearExpiry(); 
        $expired_product = $this->getAllExpired(); 
        $reorder_product = $this->getAllReOrder(); 

        //count notifs
        $near_expiry_count = $near_expiry_product->count();
        $expired_count = $expired_product->count();
        $reorder_count = $reorder_product->count();

        return view('/inventory/notification',
            [
            'suplr' => $suplr,
            'nearExpiryProduct' => $near_expiry_product,
            'expiredProduct' => $expired_product,
            'reorderProduct' => $reorder_product,
            'expiredCount' => $expired_count, 
            'expiryCount' => $near_expiry_count, 
            'reorderCount' => $reorder_count,     
            'getCurrentDate' => date('yy-m-d')        
            ]);
    }


    public function getAllNotif(){
        $near_expiry_product = $this->getAllNearExpiry(); 
        $expired_product = $this->getAllExpired(); 
        $reorder_product = $this->getAllReOrder(); 

        //count 
        $near_expiry_count = $near_expiry_product->count();
        $expired_count = $expired_product->count();
        $reorder_count = $reorder_product->count();

        $sanaAll = $near_expiry_count + $expired_count + $reorder_count;
        $counts = $near_expiry_count .' '. $expired_count .' '. $reorder_count .' '. $sanaAll;
        $arr = explode(' ', $counts);
        
        return $arr;
    }

  

    public function getAllNearExpiry()
    {
        $product = DB::table($this->table_prod)
        ->select("tblproduct.*", DB::raw('CONCAT(tblproduct._prefix, tblproduct.id) AS productCode,  unit, category_name, DATE_FORMAT(exp_date,"%d-%m-%Y") as exp_date'))
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
        ->select("tblproduct.*", DB::raw('CONCAT(tblproduct._prefix, tblproduct.id) AS productCode, unit, category_name, supplierName'))
        ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
        ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
        ->leftJoin($this->table_unit, $this->table_unit . '.id', '=', $this->table_prod . '.unitID')
        ->whereRaw('tblproduct.qty <= tblproduct.re_order')
        ->paginate(10);

        return $product;
    }

}
