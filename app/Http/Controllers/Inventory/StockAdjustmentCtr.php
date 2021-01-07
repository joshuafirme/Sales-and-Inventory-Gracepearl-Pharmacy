<?php
namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Input;
use App\ProductMaintenance;
use App\StockAdjustment;
use App\Classes\UserAccessRights;

class StockAdjustmentCtr extends Controller
{
    private $table_prod = "tblproduct";
    private $table_cat = "tblcategory";
    private $table_suplr = "tblsupplier";
    private $table_unit = "tblunit";
    private $table_stockad = "tblstockadjustment";
    private $table_emp = "tblemployee";
    private $module = "Inventory";

    public function index()
    {
        $rights = new UserAccessRights;

        if(!($rights->isUserAuthorize($this->module)))
        {
            $rights->notAuthMessage();
        }

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

    public function getAllProduct(){
        $product = DB::table($this->table_prod.' AS P')
            ->select("P.*", DB::raw('CONCAT(P._prefix, P.id) AS productCode, supplierName, category_name, unit'))
            ->leftJoin($this->table_suplr.' AS S', 'S.id', '=', 'P.supplierID')
            ->leftJoin($this->table_cat.' AS C', 'C.id', '=', 'P.categoryID')
            ->leftJoin($this->table_unit.' AS U', 'U.id', '=', 'P.unitID')
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
        $product = DB::table($this->table_prod.' AS P')
            ->select("P.*", DB::raw('CONCAT(P._prefix, P.id) AS productCode, supplierName, category_name, unit'))
            ->leftJoin($this->table_suplr.' AS S', 'S.id', '=', 'P.supplierID')
            ->leftJoin($this->table_cat.' AS C', 'C.id', '=', 'P.categoryID')
            ->leftJoin($this->table_unit.' AS U', 'U.id', '=', 'P.unitID')
            ->where('P.id', $productCode)
            ->get();

            return $product;
    }

    public function getPrefix()
    {
        $prefix = 'SA-'.date('m');
        return $prefix;
    }

}
