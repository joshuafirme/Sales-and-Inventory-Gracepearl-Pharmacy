<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProductDetailCtr extends Controller
{
    private $table_prod = "tblproduct";
    private $table_cat = "tblcategory";
    private $table_unit = "tblunit";

    public function index(){
        return view('customer/product_detail');
    }

    public function getProductDetails($product_code){

        $details = DB::table($this->table_prod)
        ->select("tblproduct.*",'unit, category_name')
        ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
        ->leftJoin($this->table_unit, $this->table_unit . '.id', '=', $this->table_prod . '.unitID')
        ->where(DB::raw('CONCAT(tblproduct._prefix, tblproduct.id)'), $product_code)
        ->get();
  
        return $details;      
      } 
}
