<?php

namespace App\Http\Controllers\Utilities;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\UserAccessRights;
use App\Classes\AuditTrailHelper;
use App\Model\Maintenance\Product;
use Illuminate\Support\Facades\DB;

class ArchiveCtr extends Controller
{

    private $table_prod = "tblproduct";
    private $table_exp = "tblexpiration";
    private $table_cat = "tblcategory";
    private $table_suplr = "tblsupplier";
    private $table_unit = "tblunit";
    private $table_emp = "tblemployee";
    private $module = "Maintenance";

    public function index(Request $request)
    {
        $rights = new UserAccessRights;

        if(!($rights->isUserAuthorize($this->module)))
        {
            return view('/layouts.not_auth');
        }      
        
        return view('utilities.archive');
    }

    public function displayArchivedProduct(Request $request){
        if(request()->ajax())
        {     
            return datatables()->of($this->getAllProduct())
            ->addColumn('action', function($product){
               $button = '<a class="btn btn-sm retrieve-data" product-id="'. $product->id_exp .'"><i  style="color:#198B4C;" class="fa fa-recycle"></i></a>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);     
           
        }
    }

    public function getAllProduct(){
        $product = DB::table($this->table_exp.' AS E')
        ->select("E.*", 'E.product_code','E.id as id_exp', 'P.id as product_id','P.description','P.re_order','P.orig_price', 'P.selling_price', 'E.qty', 'unit','supplierName','category_name', 
         DB::raw('DATE_FORMAT(E.exp_date,"%d-%m-%Y") as exp_date'))
        ->leftJoin($this->table_prod.' AS P', DB::raw('CONCAT(P._prefix, P.id)'), '=', 'E.product_code')
        ->leftJoin($this->table_suplr.' AS S', 'S.id', '=', 'P.supplierID')
        ->leftJoin($this->table_cat.' AS C', 'C.id', '=', 'P.categoryID')
        ->leftJoin($this->table_unit.' AS U', 'U.id', '=', 'P.unitID')
        ->where('E.archive_status', '=', 1)
        ->get();

        return $product;
    }

    public function retrieveProduct($id){
        DB::table('tblexpiration')
            ->where('id', $id)
            ->update([
                'archive_status' => 0
            ]);
    }

    public function bulkRetrieveProduct($id){

        $id_arr = explode(", ", $id);
        for($i = 0; $i < count($id_arr); $i++) {

            DB::table('tblexpiration')
            ->where('id', $id_arr[$i])
            ->update([
                'archive_status' => 0,
                'updated_at' => date('Y-m-d h:m:s')
            ]);
                
        }
    }

    public function displayArchivedSales(Request $request){
        if(request()->ajax())
        {     
            return datatables()->of($this->getSalesByDate($request->date_from, $request->date_to))
            ->addColumn('action', function($s){
               $button = '<a class="btn btn-sm" id="btn-restore-sales" sales-id="'. $s->id .'"><i  style="color:#198B4C;" class="fa fa-recycle"></i></a>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);     
           
        }
    }

    public function getSalesByDate($date_from, $date_to){
        // dd('test');
         $product = DB::table($this->table_sales)
         ->select("tblsales.*", DB::raw('CONCAT(tblsales._prefix, tblsales.transactionNo) AS transNo,  DATE_FORMAT(date,"%d-%m-%Y") as date, description, unit, supplierName, category_name'))
         ->leftJoin($this->table_prod,  DB::raw('CONCAT('.$this->table_prod.'._prefix, '.$this->table_prod.'.id)'), '=', $this->table_sales . '.product_code')
         ->leftJoin($this->table_suplr.' AS S', 'S.id', '=', 'P.supplierID')
         ->leftJoin($this->table_cat.' AS C', 'C.id', '=', 'P.categoryID')
         ->leftJoin($this->table_unit.' AS U', 'U.id', '=', 'P.unitID')
         ->whereBetween('date', [$date_from, $date_to])
         ->get();
 
         return $product;
     }

     public function retrieveSales($id){
        DB::table('tblsales')
            ->where('id', $id)
            ->update([
                'archive_status' => 0
            ]);
    }

    
}
