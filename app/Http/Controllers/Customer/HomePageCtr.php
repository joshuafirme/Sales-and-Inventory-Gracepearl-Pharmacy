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
     // $str = "Hello, world, beautiful, day.";
    //  $cat_arr = explode(', ',$str);
    //  dd($cat_imp = implode('", "', $cat_arr));
        return view('/customer/homepage', 
        [
          'products' => $this->getAllProduct(),
          'maxPrice' => $this->getMaxPrice()
          ]);
      }

    
    public function getAllProduct()
    {
      $limit = Input::input('limit');
      if($limit){
        $product = DB::table($this->table_prod.' AS P')
        ->select("P.*", DB::raw('CONCAT(P._prefix, P.id) AS product_code, unit, category_name, supplierName'))
        ->leftJoin($this->table_suplr.' AS S', 'S.id', '=', 'P.supplierID')
        ->leftJoin($this->table_cat.' AS C', 'C.id', '=', 'P.categoryID')
        ->leftJoin($this->table_unit.' AS U', 'U.id', '=', 'P.unitID')
        ->whereRaw('exp_date >= CURDATE()')
        ->limit($limit)
        ->get();
      }
      else{
        $product = DB::table($this->table_prod.' AS P')
        ->select("P.*", DB::raw('CONCAT(P._prefix, P.id) AS product_code, unit, category_name, supplierName'))
        ->leftJoin($this->table_suplr.' AS S', 'S.id', '=', 'P.supplierID')
          ->leftJoin($this->table_cat.' AS C', 'C.id', '=', 'P.categoryID')
          ->leftJoin($this->table_unit.' AS U', 'U.id', '=', 'P.unitID')
        ->whereRaw('exp_date >= CURDATE()')
        ->limit(8)
        ->get();
      }
     

      return $product;      
    }  

    public function searchProduct($search_key)
    {
        $categories = Input::input('categories');
        $limit = Input::input('limit');
        $cat_arr = explode(', ',$categories);
        $cat_imp = implode('", "', $cat_arr);

        if($search_key){
          $product = DB::table($this->table_prod.' AS P')
          ->select("P.*", DB::raw('CONCAT(P._prefix, P.id) AS product_code, unit, category_name, supplierName'))
          ->leftJoin($this->table_suplr.' AS S', 'S.id', '=', 'P.supplierID')
          ->leftJoin($this->table_cat.' AS C', 'C.id', '=', 'P.categoryID')
          ->leftJoin($this->table_unit.' AS U', 'U.id', '=', 'P.unitID')
         ->whereRaw('exp_date >= CURDATE()')
          ->where('description', 'LIKE', '%'.$search_key.'%')
          ->whereRaw('C.category_name IN ("'.$cat_imp.'")')
          ->limit($limit)
          ->get();
        }
        else{
          $product = DB::table($this->table_prod.' AS P')
          ->select("P.*", DB::raw('CONCAT(P._prefix, P.id) AS product_code, unit, category_name, supplierName'))
          ->leftJoin($this->table_suplr.' AS S', 'S.id', '=', 'P.supplierID')
          ->leftJoin($this->table_cat.' AS C', 'C.id', '=', 'P.categoryID')
          ->leftJoin($this->table_unit.' AS U', 'U.id', '=', 'P.unitID')
          ->whereRaw('exp_date >= CURDATE()')
          ->whereRaw('C.category_name IN ("'.$cat_imp.'")')
          ->limit($limit)
          ->get();
        }

       

        return $product;         
    } 
    
    public function filterProduct()
    {
     
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
