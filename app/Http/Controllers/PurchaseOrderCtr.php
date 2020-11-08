<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\ProductMaintenance;

class PurchaseOrderCtr extends Controller
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
                ->addColumn('action', function($product){
                    $button = ' <a class="btn" id="btn-reorder" product-code="'. $product->id .'" data-toggle="modal" data-target="#purchaseOrderModal"><i class="fa fa-cart-plus"></i></a>';
               
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
           
        }
        return view('/inventory/purchase_order', ['product' => $product, 'unit' => $unit, 'category' => $category, 'suplr' => $suplr]);
    }

    public function getAllProduct(){
        $product = DB::table($this->table_prod)
        ->select("tblproduct.*", DB::raw('CONCAT(tblproduct._prefix, tblproduct.id) AS productCode, unit, supplierName'))
        ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
        ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
        ->leftJoin($this->table_unit, $this->table_unit . '.id', '=', $this->table_prod . '.unitID')
        ->whereColumn('tblproduct.re_order','>=', 'tblproduct.qty')
        ->get();
 

        return $product;
    }
}
