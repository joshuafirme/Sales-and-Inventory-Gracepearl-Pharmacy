<?php

namespace App\Model\Maintenance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\ProductMaintenance;
use App\SupplierMaintenance;

class Product extends Model
{
    private $table_prod = "tblproduct";
    private $table_exp = "tblexpiration";
    private $table_cat = "tblcategory";
    private $table_suplr = "tblsupplier";
    private $table_unit = "tblunit";
    private $table_emp = "tblemployee";
    private $module = "Maintenance";


    public function getAllProduct(){
        $product = DB::table($this->table_exp.' AS E')
        ->select("E.*", 'E.product_code','E.id as id_exp', 'P.id as product_id',
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
        ->get();

        return $product;
    }

    public function filterByCategory($category_param){
        $product = DB::table($this->table_exp.' AS E')
        ->select("E.*", 'E.product_code', 'E.id as id_exp', 'P.id as product_id',
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
        ->get();

        return $product;
    }

    

    public function show($productCode)
    {
        $product = DB::table($this->table_exp.' AS E')
        ->select("P.*", 'E.product_code', 'E.id as id_exp', 'P.id as product_id',
                 'unit', 
                 'supplierName', 
                 'category_name', 
                 'image', 
                 'E.qty', 
                 'E.exp_date')
            ->leftJoin($this->table_prod.' AS P', DB::raw('CONCAT(P._prefix, P.id)'), '=', 'E.product_code')
            ->leftJoin($this->table_suplr.' AS S', 'S.id', '=', 'P.supplierID')
            ->leftJoin($this->table_cat.' AS C', 'C.id', '=', 'P.categoryID')
            ->leftJoin($this->table_unit.' AS U', 'U.id', '=', 'P.unitID')
            ->where('E.id', $productCode)
            ->get();

            return $product;
    }


    public function storeHighlights($id){
        DB::table($this->table_prod)
        ->where('id', $id)
        ->update();
    }


}

