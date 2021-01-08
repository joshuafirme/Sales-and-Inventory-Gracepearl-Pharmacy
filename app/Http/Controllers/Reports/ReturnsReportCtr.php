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

    public function index(){
        $rights = new UserAccessRights;

        if(!($rights->isUserAuthorize($this->module)))
        {
            $rights->notAuthMessage();
        }

        $get_returns = $this->getReturns();
        
        if(request()->ajax())
        {       
            return datatables()->of($get_returns)
            ->make(true);            
        }
        
        return view('reports/returns_report');
    }


    public function getReturns(){
        $ret = DB::table($this->tbl_return)
        ->select($this->tbl_return.".*", DB::raw('CONCAT('.date('y').', '.$this->tbl_return.'.id) AS returnID, DATE_FORMAT(date,"%d-%m-%Y") as date, description, unit, supplierName, category_name'))
        ->leftJoin($this->tbl_prod,  DB::raw('CONCAT('.$this->tbl_prod.'._prefix, '.$this->tbl_prod.'.id)'), '=', $this->tbl_return . '.product_code')
        ->leftJoin($this->tbl_suplr, $this->tbl_suplr . '.id', '=', $this->tbl_prod . '.supplierID')
        ->leftJoin($this->tbl_cat, $this->tbl_cat . '.id', '=', $this->tbl_prod . '.categoryID')
        ->leftJoin($this->tbl_unit, $this->tbl_unit . '.id', '=', $this->tbl_prod . '.unitID')
        ->get();

        return $ret;
    }
}
