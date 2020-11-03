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
                $button = ' <a class="btn" id="btn-edit-product-maintenance" product-code="'. $product->id .'" data-toggle="modal" data-target="#editProductModal"><i class="fa fa-edit"></i></a>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<a class="btn" id="delete-product" delete-id="'. $product->id .'"><i class="fa fa-trash"></i></a>';
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

    public function adjust(Request $request){
       $action = $request->get('rdo-addless');
        if($action == 'Add'){

            $stockad = new StockAdjustment;

            $stockad->_prefix = $this->getPrefix();
            $stockad->product_code = $request->input('product_code_hidden');
            $stockad->qtyToAdjust = $request->input('qty-to-adjust');
            $stockad->action = 'Add';
            $stockad->remarks = $request->input('remarks');
            $stockad->save();
            updateStock($action, $stockad->product_code, $stockad->qtyToAdjust);
        }
        else{
            $stockad = new StockAdjustment;

            $stockad->_prefix = $this->getPrefix();
            $stockad->product_code = $request->input('product_code');
            $stockad->qtyToAdjust = $request->input('qty-to-adjust');
            $stockad->action = 'Less';
            $stockad->remarks = $request->input('remarks');
            $stockad->save();
            updateStock($action, $stockad->product_code, $stockad->qtyToAdjust);
        }
    }

    public function getPrefix()
    {
        $prefix = 'SA-'.date('m');
        return $prefix;
    }

    public function updateStock($action, $product_code, $qtyAdjusted){
        if($action == 'Add'){
            DB::update('UPDATE '. $this->table_prod .' 
            SET qty = ?
            WHERE id = ?',
            [
                $product_code,
                'qty' + $qtyAdjusted
            ]);
        }
        else if($action == 'Less'){
            DB::update('UPDATE '. $this->table_prod .' 
            SET qty = ?
            WHERE id = ?',
            [
                $product_code,
                'qty' - $qtyAdjusted
            ]);
        }
    }

}
