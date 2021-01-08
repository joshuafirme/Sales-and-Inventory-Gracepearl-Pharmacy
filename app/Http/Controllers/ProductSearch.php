<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\ProductMaintenance;

class ProductSearch extends Controller
{
    private $table_prod = "tblproduct";
    private $table_cat = "tblcategory";
    private $table_suplr = "tblsupplier";
    private $table_unit = "tblunit";

    public function index(Request $request)
    {
        $category_param = $request->category;
        $product = $this->getAllProduct(); 
        $unit = DB::table($this->table_unit)->get();
        $category = DB::table($this->table_cat)->get();
        $suplr = DB::table($this->table_suplr)->get();
        
        if(request()->ajax())
        {
           
                return datatables()->of($product)
                ->make(true);
           
        }
        return view('/products', ['product' => $product, 'unit' => $unit, 'category' => $category, 'suplr' => $suplr]);
    }

    public function getAllProduct(){
        $product = DB::table($this->table_prod.' AS P')
        ->select("P.*", DB::raw('CONCAT(P._prefix, P.id) AS productCode, unit, category_name, supplierName, DATE_FORMAT(exp_date,"%d-%m-%Y") as exp_date'))
        ->leftJoin($this->table_suplr.' AS S', 'S.id', '=', 'P.supplierID')
        ->leftJoin($this->table_cat.' AS C', 'C.id', '=', 'P.categoryID')
        ->leftJoin($this->table_unit.' AS U', 'U.id', '=', 'P.unitID')
        ->get();

        return $product;
    }
}
