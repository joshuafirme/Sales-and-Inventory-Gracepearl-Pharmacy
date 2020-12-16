<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Input;
use App\ProductMaintenance;

class HomePageCtr extends Controller
{
    private $table_prod = "tblproduct";
    private $table_cat = "tblcategory";
    private $table_suplr = "tblsupplier";
    private $table_unit = "tblunit";
    private $tbl_cart = "tblcart";

    public function index(){

        return view('/customer/homepage', 
        [
          'products' => $this->getAllProduct(),
          'maxPrice' => $this->getMaxPrice()
          ]);
      }

    

    public function getAllProduct(){
      $product = DB::table($this->table_prod)
      ->select("tblproduct.*", DB::raw('CONCAT(tblproduct._prefix, tblproduct.id) AS product_code, unit, category_name, supplierName'))
      ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
      ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
      ->leftJoin($this->table_unit, $this->table_unit . '.id', '=', $this->table_prod . '.unitID')
      ->whereRaw('exp_date >= CURDATE()')
      ->paginate(10);

      return $product;      
    }  
    
    public function getMaxPrice(){
      $price = DB::table($this->table_prod)
      ->max('selling_price');

      return $price;      
    } 

    public function getPriceFilter($min_price, $max_price){
      $price = DB::table($this->table_prod)
      ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
      ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
      ->leftJoin($this->table_unit, $this->table_unit . '.id', '=', $this->table_prod . '.unitID')
      ->whereBetween('selling_price', [$min_price, $max_price])
      ->get();

      return $price;      
    } 

    
}
