<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Classes\UserAccessRights;

class StockAdjustmentReportCtr extends Controller
{
    private $tbl_prod = "tblproduct";
    private $tbl_cat = "tblcategory";
    private $tbl_suplr = "tblsupplier";
    private $tbl_unit = "tblunit";
    private $tbl_stockad = "tblstockadjustment";
    private $module = "Reports";

    public function index(Request $request){
        $rights = new UserAccessRights;

        if(!($rights->isUserAuthorize($this->module)))
        {
            $rights->notAuthMessage();
        }
        $stock_ad = $this->getStockAdjustment($request->date_from, $request->date_to);

        if(request()->ajax())
        {
            return datatables()->of($stock_ad)
            ->make(true);  
        }
        
        return view('reports/stockadjustment',['currentDate' => $this->getDate()]);
    }

    public function getStockAdjustment($date_from, $date_to)
    {
        $product = DB::table($this->tbl_stockad.' AS SA')
        ->select("SA.*", 'description', 'unit', 'category_name', 'supplierName', DB::raw('DATE(SA.created_at) as created_at'))
        ->leftJoin($this->tbl_prod.' AS P',  DB::raw('CONCAT(P._prefix, P.id)'), '=', 'SA.product_code')
        ->leftJoin($this->tbl_suplr.' AS S', 'S.id', '=', 'P.supplierID')
        ->leftJoin($this->tbl_cat.' AS C', 'C.id', '=', 'P.categoryID')
        ->leftJoin($this->tbl_unit.' AS U', 'U.id', '=', 'P.unitID')
        ->whereBetween('SA.created_at', [$date_from, $date_to])
        ->get();

        return $product;     
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
