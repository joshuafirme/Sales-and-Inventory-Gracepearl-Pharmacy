<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Classes\UserAccessRights;

class ExpiredProductReportCtr extends Controller
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

        $exp = $this->getAllExpired();

        if(request()->ajax())
        {
            return datatables()->of($exp)
            ->make(true);  
        }
        
        return view('reports/expired_report');
    }

    
    public function getAllExpired()
    {
        $product = DB::table($this->tbl_prod.' AS P')
        ->select("P.*", DB::raw('CONCAT(P._prefix, P.id) AS product_code, unit, category_name, supplierName, DATE_FORMAT(exp_date,"%d-%m-%Y") as exp_date'))
        ->leftJoin($this->tbl_suplr.' AS S', 'S.id', '=', 'P.supplierID')
        ->leftJoin($this->tbl_cat.' AS C', 'C.id', '=', 'P.categoryID')
        ->leftJoin($this->tbl_unit.' AS U', 'U.id', '=', 'P.unitID')
        ->whereRaw('P.exp_date <= CURDATE()')
        ->get();

        return $product;
    }
}
