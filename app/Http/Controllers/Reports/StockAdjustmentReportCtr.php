<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class StockAdjustmentReportCtr extends Controller
{
    private $tbl_prod = "tblproduct";
    private $tbl_cat = "tblcategory";
    private $tbl_suplr = "tblsupplier";
    private $tbl_unit = "tblunit";
    private $tbl_stockad = "tblstockadjustment";
    private $module = "Inventory";

    public function index(){

        $stock_ad = $this->getStockAdjustment();

        if(request()->ajax())
        {
            return datatables()->of($stock_ad)
            ->make(true);  
        }
        
        return view('reports/stockadjustment');
    }

    public function getStockAdjustment()
    {
        $product = DB::table($this->tbl_stockad.' AS SA')
        ->select("SA.*", 'description', 'unit', 'category_name', 'supplierName')
        ->leftJoin($this->tbl_prod.' AS P',  DB::raw('CONCAT(P._prefix, P.id)'), '=', 'SA.product_code')
        ->leftJoin($this->tbl_suplr.' AS S', 'S.id', '=', 'P.supplierID')
        ->leftJoin($this->tbl_cat.' AS C', 'C.id', '=', 'P.categoryID')
        ->leftJoin($this->tbl_unit.' AS U', 'U.id', '=', 'P.unitID')
        ->get();

        return $product;     
    }
}
