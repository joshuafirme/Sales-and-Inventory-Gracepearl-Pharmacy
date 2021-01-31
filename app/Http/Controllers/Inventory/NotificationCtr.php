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
    private $table_exp = "tblexpiration";
    private $table_cat = "tblcategory";
    private $table_suplr = "tblsupplier";
    private $table_unit = "tblunit";
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
        $product = DB::table($this->table_exp.' AS E')
        ->select("E.*", 'E.product_code',
                 'P.description',
                 'P.re_order', 
                 'P.orig_price', 
                 'P.selling_price', 
                 'E.qty', 
                 'unit', 
                 'supplierName', 
                 'category_name', 
                 DB::raw('DATE_FORMAT(E.exp_date,"%d-%m-%Y") as exp_date'))
            ->leftJoin($this->table_prod.' AS P', DB::raw('CONCAT(P._prefix, P.id)'), '=', 'E.product_code')
            ->leftJoin($this->table_suplr.' AS S', 'S.id', '=', 'P.supplierID')
            ->leftJoin($this->table_cat.' AS C', 'C.id', '=', 'P.categoryID')
            ->leftJoin($this->table_unit.' AS U', 'U.id', '=', 'P.unitID')
        ->whereRaw('E.exp_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 3 MONTH)')
        ->paginate(10);

        return $product;
    }


    public function getAllExpired()
    {
        $product = DB::table($this->table_exp.' AS E')
        ->select("E.*", 'E.product_code',
                 'P.description',
                 'P.re_order', 
                 'P.orig_price', 
                 'P.selling_price', 
                 'E.qty', 
                 'unit', 
                 'supplierName', 
                 'category_name', 
                 DB::raw('DATE_FORMAT(E.exp_date,"%d-%m-%Y") as exp_date'))
            ->leftJoin($this->table_prod.' AS P', DB::raw('CONCAT(P._prefix, P.id)'), '=', 'E.product_code')
            ->leftJoin($this->table_suplr.' AS S', 'S.id', '=', 'P.supplierID')
            ->leftJoin($this->table_cat.' AS C', 'C.id', '=', 'P.categoryID')
            ->leftJoin($this->table_unit.' AS U', 'U.id', '=', 'P.unitID')
        ->whereRaw('E.exp_date <= CURDATE()')
        ->paginate(10);

        return $product;
    }

    public function getAllReOrder()
    {
        $product = DB::table($this->table_exp.' AS E')
        ->select("E.*", 'E.product_code',
                 'P.description',
                 'P.re_order', 
                 'P.orig_price', 
                 'P.selling_price', 
                 'E.qty', 
                 'unit', 
                 'supplierName', 
                 'category_name', 
                 DB::raw('DATE_FORMAT(E.exp_date,"%d-%m-%Y") as exp_date'))
            ->leftJoin($this->table_prod.' AS P', DB::raw('CONCAT(P._prefix, P.id)'), '=', 'E.product_code')
            ->leftJoin($this->table_suplr.' AS S', 'S.id', '=', 'P.supplierID')
            ->leftJoin($this->table_cat.' AS C', 'C.id', '=', 'P.categoryID')
            ->leftJoin($this->table_unit.' AS U', 'U.id', '=', 'P.unitID')
        ->whereRaw('E.qty <= P.re_order')
        ->paginate(10);

        return $product;
    }

}
