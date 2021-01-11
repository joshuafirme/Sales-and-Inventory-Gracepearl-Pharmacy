<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\UserAccessRights;
use Illuminate\Support\Facades\DB;

class ReturnsReportCtr extends Controller
{
    private $tbl_prod = "tblproduct";
    private $tbl_cat = "tblcategory";
    private $tbl_suplr = "tblsupplier";
    private $tbl_unit = "tblunit";
    private $tbl_return = "tblreturn_change";
    private $module = "Reports";

    public function index(Request $request){
        $rights = new UserAccessRights;

        if(!($rights->isUserAuthorize($this->module)))
        {
            $rights->notAuthMessage();
        }

        $get_returns = $this->getReturns($request->date_from, $request->date_to);
        
        if(request()->ajax())
        {       
            return datatables()->of($get_returns)
            ->make(true);            
        }
        
        return view('reports/returns_report',['currentDate' => $this->getDate()]);
    }


    public function getReturns($date_from, $date_to){
        $ret = DB::table($this->tbl_return.' AS R')
        ->select("R.*", DB::raw('CONCAT('.date('y').', R.id) AS returnID, DATE_FORMAT(date,"%d-%m-%Y") as date, description, unit, supplierName, category_name'))
        ->leftJoin($this->tbl_prod.' AS P',  DB::raw('CONCAT(P._prefix, P.id)'), '=', 'R.product_code')
        ->leftJoin($this->tbl_suplr.' AS S', 'S.id', '=', 'P.supplierID')
        ->leftJoin($this->tbl_cat.' AS C', 'C.id', '=', 'P.categoryID')
        ->leftJoin($this->tbl_unit.' AS U', 'U.id', '=', 'P.unitID')
        ->whereBetween('R.created_at', [$date_from, $date_to])
        ->get();

        return $ret;
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
