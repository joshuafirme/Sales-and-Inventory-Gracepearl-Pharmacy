<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Classes\UserAccessRights;

class FastAndSlowMovingReportCtr extends Controller
{
    private $tbl_prod = "tblproduct";
    private $tbl_cat = "tblcategory";
    private $tbl_suplr = "tblsupplier";
    private $tbl_unit = "tblunit";
    private $module = "Reports";

    public function index(){
        $rights = new UserAccessRights;

        if(!($rights->isUserAuthorize($this->module)))
        {
            $rights->notAuthMessage();
        }


        if(request()->ajax())
        {
        }
        
        return view('reports/fast_and_slow_moving');
    }


    public function getFastAndSlowMoving($date_from, $date_to){
        $p = DB::table($this->table_prod.' AS P')
        ->select("P.*", 
        DB::raw('CONCAT(P._prefix, P.id) AS productCode, unit, supplierName, category_name, DATE_FORMAT(exp_date,"%d-%m-%Y") as exp_date'))
        ->leftJoin($this->table_suplr.' AS S', 'S.id', '=', 'P.supplierID')
        ->leftJoin($this->table_cat.' AS C', 'C.id', '=', 'P.categoryID')
        ->leftJoin($this->table_unit.' AS U', 'U.id', '=', 'P.unitID')
        ->whereBetween('P.date', [$date_from, $date_to])
        ->get();

        return $p;
    }

}
