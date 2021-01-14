<?php

namespace App\Model\Maintenance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\ProductMaintenance;
use App\SupplierMaintenance;

class Product extends Model
{
    private $table_prod = "tblproduct";
    private $table_cat = "tblcategory";
    private $table_suplr = "tblsupplier";
    private $table_unit = "tblunit";
    private $table_emp = "tblemployee";
    private $module = "Maintenance";


    public function getAllProduct(){
        $product = DB::table($this->table_prod.' AS P')
        ->select("P.*", 
        DB::raw('CONCAT(P._prefix, P.id) AS productCode, unit, supplierName, category_name, DATE_FORMAT(exp_date,"%d-%m-%Y") as exp_date'))
        ->leftJoin($this->table_suplr.' AS S', 'S.id', '=', 'P.supplierID')
        ->leftJoin($this->table_cat.' AS C', 'C.id', '=', 'P.categoryID')
        ->leftJoin($this->table_unit.' AS U', 'U.id', '=', 'P.unitID')
        ->orderBy('P.id', 'desc')
        ->get();

        return $product;
    }

    public function filterByCategory($category_param){
        $product = DB::table($this->table_prod.' AS P')
        ->select("P.*", 
        DB::raw('CONCAT(P._prefix, P.id) AS productCode, unit, supplierName, category_name, DATE_FORMAT(exp_date,"%d-%m-%Y") as exp_date'))
        ->leftJoin($this->table_suplr.' AS S', 'S.id', '=', 'P.supplierID')
        ->leftJoin($this->table_cat.' AS C', 'C.id', '=', 'P.categoryID')
        ->leftJoin($this->table_unit.' AS U', 'U.id', '=', 'P.unitID')
        ->where('categoryID', $category_param)
        ->orderBy('P.id', 'desc')
        ->get();

        return $product;
    }

    

    public function show($productCode)
    {
        $product = DB::table($this->table_prod.' AS P')
        ->select("P.*", 
        DB::raw('CONCAT(P._prefix, P.id) AS productCode, unit, supplierName, category_name, DATE_FORMAT(exp_date,"%d-%m-%Y") as exp_date'))
            ->leftJoin($this->table_suplr.' AS S', 'S.id', '=', 'P.supplierID')
            ->leftJoin($this->table_cat.' AS C', 'C.id', '=', 'P.categoryID')
            ->leftJoin($this->table_unit.' AS U', 'U.id', '=', 'P.unitID')
            ->where('P.id', $productCode)
            ->get();

            return $product;
    }


    public function storeHighlights($id){
        DB::table($this->table_prod)
        ->where('id', $id)
        ->update();
    }


}

