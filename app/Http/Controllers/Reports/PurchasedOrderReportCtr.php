<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Classes\UserAccessRights;

class PurchasedOrderReportCtr extends Controller
{
    private $tbl_prod = "tblproduct";
    private $tbl_cat = "tblcategory";
    private $tbl_suplr = "tblsupplier";
    private $tbl_unit = "tblunit";
    private $tbl_po = "tblpurchaseorder";
    private $module = "Reports";

    public function index(Request $request){
        $rights = new UserAccessRights;

        if(!($rights->isUserAuthorize($this->module)))
        {
            $rights->notAuthMessage();
        }

        $po = $this->getPurchasedOrder($request->date_from, $request->date_to, $request->supplier);

        if(request()->ajax())
        {
            return datatables()->of($po)
            ->make(true);  
        }

        $suplr = DB::table($this->tbl_suplr)->get();

        return view('reports/po_report',[
            'currentDate' => $this->getDate(), 
            'suplr' => $suplr
            ]);
    }

    public function getPurchasedOrder($date_from, $date_to, $supplier){
        
        if($supplier !== 'All Supplier'){
            $po = DB::table($this->tbl_po.' AS PO')
            ->select("PO.*", DB::raw('CONCAT(PO._prefix, PO.po_num) AS po_num, DATE_FORMAT(date,"%d-%m-%Y") as date, description, unit, supplierName, category_name'))
            ->leftJoin($this->tbl_prod.' AS P',  DB::raw('CONCAT(P._prefix, P.id)'), '=', 'PO.product_code')
            ->leftJoin($this->tbl_suplr.' AS S', 'S.id', '=', 'P.supplierID')
            ->leftJoin($this->tbl_cat.' AS C', 'C.id', '=', 'P.categoryID')
            ->leftJoin($this->tbl_unit.' AS U', 'U.id', '=', 'P.unitID')
            ->whereBetween('PO.date', [$date_from, $date_to])
            ->where('S.supplierName', $supplier)
            ->orderBy('date', 'desc')
            ->get();
        }
        else{
            $po = DB::table($this->tbl_po.' AS PO')
            ->select("PO.*", DB::raw('CONCAT(PO._prefix, PO.po_num) AS po_num, DATE_FORMAT(date,"%d-%m-%Y") as date, description, unit, supplierName, category_name'))
            ->leftJoin($this->tbl_prod.' AS P',  DB::raw('CONCAT(P._prefix, P.id)'), '=', 'PO.product_code')
            ->leftJoin($this->tbl_suplr.' AS S', 'S.id', '=', 'P.supplierID')
            ->leftJoin($this->tbl_cat.' AS C', 'C.id', '=', 'P.categoryID')
            ->leftJoin($this->tbl_unit.' AS U', 'U.id', '=', 'P.unitID')
            ->whereBetween('PO.date', [$date_from, $date_to])
            ->orderBy('date', 'desc')
            ->get();
        }

        return $po;
    }

    public function getDate(){
        return $date = $this->getYear().'-'.$this->getMonth().'-'.$this->getDay();
    }
     
    public function getYear(){
        return $year = date('yy')-100;
    }

    public function getMonth(){
        return $month = date('m');
    }

    public function getDay(){
        return $month = date('d');
    }
}
