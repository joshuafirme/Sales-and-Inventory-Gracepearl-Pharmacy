<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\UserAccessRights;
use Illuminate\Support\Facades\DB;

class ReOrderReportCtr extends Controller
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

        $reorder = $this->getAllReOrder();
        
        if(request()->ajax())
        {       
            return datatables()->of($reorder)
            ->make(true);            
        }
        
        return view('reports/reorder_report');
    }

    public function getAllReOrder()
    {
        $product = DB::table('tblexpiration AS E')
        ->select("E.*", 'E.product_code',
                 'P.description',
                 'P.re_order', 
                 'P.orig_price', 
                 'P.selling_price', 
                 'E.qty', 
                 'unit', 
                 'supplierName', 
                 'category_name', 
                 DB::raw('DATE_FORMAT(E.exp_date,"%d-%m-%Y") as exp_date'))
            ->leftJoin($this->tbl_prod.' AS P', DB::raw('CONCAT(P._prefix, P.id)'), '=', 'E.product_code')
            ->leftJoin($this->tbl_suplr.' AS S', 'S.id', '=', 'P.supplierID')
            ->leftJoin($this->tbl_cat.' AS C', 'C.id', '=', 'P.categoryID')
            ->leftJoin($this->tbl_unit.' AS U', 'U.id', '=', 'P.unitID')
        ->whereRaw('P.qty <= P.re_order')
        ->get();

        return $product;
    }
}
