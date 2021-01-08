<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SupplierDeliveryReportCtr extends Controller
{
    private $tbl_prod = "tblproduct";
    private $tbl_cat = "tblcategory";
    private $tbl_suplr = "tblsupplier";
    private $tbl_unit = "tblunit";
    private $tbl_po = "tblpurchaseorder";
    private $tbl_delivery = "tblsupplier_delivery";
    private $module = "Reports";

    public function index(){

        $stock_ad = $this->getSupplierDelivery();

        if(request()->ajax())
        {
            return datatables()->of($stock_ad)
            ->make(true);  
        }
        
        return view('reports/supplierdelivery_report');
    }

    public function getSupplierDelivery()
     {
        $product = DB::table($this->tbl_delivery.' AS D')
        ->select("D.*", 
        DB::raw('CONCAT(D._prefix, D.delivery_num) AS del_num, description, supplierName, category_name, unit, qty_order,
                DATE_FORMAT(D.exp_date,"%d-%m-%Y") as exp_date, DATE_FORMAT(date_recieved,"%d-%m-%Y") as date_recieved'))
            ->leftJoin($this->tbl_prod.' AS P',  DB::raw('CONCAT(P._prefix, P.id)'), '=', 'D.product_code')
            ->leftJoin($this->tbl_po.' AS PO', 'PO.product_code', '=', 'D.product_code')
            ->leftJoin($this->tbl_suplr.' AS S', 'S.id', '=', 'P.supplierID')
            ->leftJoin($this->tbl_cat.' AS C', 'C.id', '=', 'P.categoryID')
            ->leftJoin($this->tbl_unit.' AS U', 'U.id', '=', 'P.unitID')
            ->orderBy('D.delivery_num', 'desc')
            ->get();

        return $product;
     }
}
