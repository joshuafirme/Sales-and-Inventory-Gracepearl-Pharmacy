<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\ProductMaintenance;
use App\StockAdjustment;

class StockAdjustmentCtr extends Controller
{
    private $table_prod = "tblproduct";
    private $table_cat = "tblcategory";
    private $table_suplr = "tblsupplier";
    private $table_stockad = "tblstockadjustment";

    public function index(Request $request){
        $product = $this->getAllProduct(); 
        $category = DB::table($this->table_cat)->get();
        $suplr = DB::table($this->table_suplr)->get();
        
        if(request()->ajax())
        {
            return datatables()->of($product)
            ->addColumn('action', function($product){
                $button = ' <a class="btn" id="btn-stockad" product-code="'. $product->id .'" data-toggle="modal" data-target="#stockAdjustmentModal"><i class="fa fa-sliders-h"></i></a>';
           
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
            }
           
        
        return view('inventory/stockadjustment', ['product' => $product, 'category' => $category, 'suplr' => $suplr]);
    }

    public function getAllProduct(){
        $product = DB::table($this->table_prod)
        ->select("tblproduct.*", DB::raw('CONCAT(tblproduct._prefix, tblproduct.id) AS productCode'))
        ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
        ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
        ->get();

        return $product;
    }

    public function adjust(){
       $action = Input::get('rdo_addless');
        if($action == 'add'){

            $stockad = new StockAdjustment;

            $stockad->_prefix = $this->getPrefix();
            $stockad->product_code = Input::get('product_code');
            $stockad->qtyToAdjust = Input::get('qty_to_adjust');
            $stockad->action = 'add';
            $stockad->remarks = Input::get('remarks');
            $stockad->save();
            $this->updateStock($action, $stockad->product_code, $stockad->qtyToAdjust);
        }
        else if($action == 'less'){
            $stockad = new StockAdjustment;

            $stockad->_prefix = $this->getPrefix();
            $stockad->product_code = Input::get('product_code');
            $stockad->qtyToAdjust = Input::get('qty_to_adjust');
            $stockad->action = 'less';
            $stockad->remarks = Input::get('remarks');
            $stockad->save();
            $this->updateStock($action, $stockad->product_code, $stockad->qtyToAdjust);
        }
    }

    public function getPrefix()
    {
        $prefix = 'SA-'.date('m');
        return $prefix;
    }

    public function updateStock($action, $product_code, $qtyAdjusted){
        if($action == 'add'){ 
            DB::table($this->table_prod)
            ->where('id', $product_code)
            ->update(array(
                'qty' => DB::raw('qty + '. $qtyAdjusted .'')));
        }
        else if($action == 'less'){
            DB::table($this->table_prod)
            ->where('id', $product_code)
            ->update(array(
                'qty' => DB::raw('qty - '. $qtyAdjusted .'')));
        }
    }

    public function show($productCode)
    {
        $product = DB::table($this->table_prod)
            ->select("tblproduct.*", DB::raw('CONCAT(tblproduct._prefix, tblproduct.id) AS productCode'))
            ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
            ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
            ->where('tblproduct.id', $productCode)
            ->get();

            return $product;
    }

}
