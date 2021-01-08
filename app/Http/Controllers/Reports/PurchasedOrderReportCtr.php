<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PurchasedOrderReportCtr extends Controller
{
    private $tbl_prod = "tblproduct";
    private $tbl_cat = "tblcategory";
    private $tbl_suplr = "tblsupplier";
    private $tbl_unit = "tblunit";
    private $tbl_po = "tblpurchaseorder";
    private $module = "Reports";

    public function index(){

        $po = $this->getPurchasedOrder();

        if(request()->ajax())
        {
            return datatables()->of($po)
            ->make(true);  
        }
        
        return view('reports/po_report');
    }

    public function getPurchasedOrder(){
        $po = DB::table($this->tbl_po.' AS PO')
        ->select("PO.*", DB::raw('CONCAT(PO._prefix, PO.po_num) AS po_num, DATE_FORMAT(date,"%d-%m-%Y") as date, description, unit, supplierName, category_name'))
        ->leftJoin($this->tbl_prod.' AS P',  DB::raw('CONCAT(P._prefix, P.id)'), '=', 'PO.product_code')
        ->leftJoin($this->tbl_suplr.' AS S', 'S.id', '=', 'P.supplierID')
        ->leftJoin($this->tbl_cat.' AS C', 'C.id', '=', 'P.categoryID')
        ->leftJoin($this->tbl_unit.' AS U', 'U.id', '=', 'P.unitID')
        ->orderBy('date', 'desc')
        ->get();

        return $po;
    }
}
