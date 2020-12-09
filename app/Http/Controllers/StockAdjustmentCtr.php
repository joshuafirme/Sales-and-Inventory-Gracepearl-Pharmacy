<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Input;
use App\ProductMaintenance;
use App\StockAdjustment;

class StockAdjustmentCtr extends Controller
{
    private $table_prod = "tblproduct";
    private $table_cat = "tblcategory";
    private $table_suplr = "tblsupplier";
    private $table_unit = "tblunit";
    private $table_stockad = "tblstockadjustment";
    private $table_emp = "tblemployee";
    private $this_module = "Inventory";

    public function index(Request $request){
        $this->validateUser();

        $product = $this->getAllProduct(); 
        $category = DB::table($this->table_cat)->get();
        $suplr = DB::table($this->table_suplr)->get();
        
        if(request()->ajax())
        {
            return datatables()->of($product)
            ->addColumn('action', function($product){
                $button = ' <a class="btn btn-sm" id="btn-stockad" product-code="'. $product->id .'" data-toggle="modal" data-target="#stockAdjustmentModal"><i class="fa fa-sliders-h"></i></a>';
           
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
            }
           
        
        return view('inventory/stockadjustment', ['product' => $product, 'category' => $category, 'suplr' => $suplr, 'getCurrentDate' => date('yy-m-d')]);
    }

    public function validateUser(){
        if(!($this->isUserAuthorize())){
            dd('You are not authorized to access this module, please ask the administrator');
        }
    }

    public function isUserAuthorize(){
        $emp = DB::table($this->table_emp)
        ->where([
            ['username', session()->get('emp-username')],
        ])
        ->value('auth_modules');

        $modules = explode(", ",$emp);

        if (!(in_array($this->this_module, $modules)))
        {
            return false;
        }
        else{
            return true;
        }
    }

    public function getAllProduct(){
        $product = DB::table($this->table_prod)
        ->select("tblproduct.*", DB::raw('CONCAT(tblproduct._prefix, tblproduct.id) AS productCode, supplierName, category_name, unit'))
        ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
        ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
        ->leftJoin($this->table_unit, $this->table_unit . '.id', '=', $this->table_prod . '.unitID')
        ->get();

        return $product;
    }

    public function adjust(){
       $action = Input::get('rdo_addless');
        if($action == 'add'){

            $stockad = new StockAdjustment;

            $stockad->_prefix = $this->getPrefix();
            $stockad->product_code = Input::input('product_code');
            $stockad->qtyToAdjust = Input::input('qty_to_adjust');
            $stockad->action = 'add';
            $stockad->remarks = Input::input('remarks');
            $stockad->save();
            $this->updateStock($action, $stockad->product_code, $stockad->qtyToAdjust);
        }
        else if($action == 'less'){
            $stockad = new StockAdjustment;

            $stockad->_prefix = $this->getPrefix();
            $stockad->product_code = Input::input('product_code');
            $stockad->qtyToAdjust = Input::input('qty_to_adjust');
            $stockad->action = 'less';
            $stockad->remarks = Input::input('remarks');
            $stockad->save();
            $this->updateStock($action, $stockad->product_code, $stockad->qtyToAdjust);
        }
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
            ->select("tblproduct.*", DB::raw('CONCAT(tblproduct._prefix, tblproduct.id) AS productCode, supplierName, category_name, unit'))
            ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
            ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
            ->leftJoin($this->table_unit, $this->table_unit . '.id', '=', $this->table_prod . '.unitID')
            ->where('tblproduct.id', $productCode)
            ->get();

            return $product;
    }

    public function getPrefix()
    {
        $prefix = 'SA-'.date('m');
        return $prefix;
    }

}
