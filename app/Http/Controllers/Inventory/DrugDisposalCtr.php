<?php
namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Classes\UserAccessRights;
use Illuminate\Support\Facades\DB;

class DrugDisposalCtr extends Controller
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

        $exp = $this->getExpiredProduct();

        if(request()->ajax())
        {
            return datatables()->of($exp)
            ->addColumn('action', function($product){
                $button = ' <a class="btn btn-sm" id="btn-dispose" product-code="'. $product->id .'"
                            data-toggle="modal" data-target="#disposeModal"><i class="fas fa-trash"></i></a>';
           
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);  
        }
        
        return view('/inventory/drug_disposal', ['getCurrentDate' => date('yy-m-d')]);
    }

    
    public function getExpiredProduct()
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
        ->whereRaw('E.exp_date <= CURDATE()')
        ->get();

        return $product;
    }

    public function dispose($id)
    {
        $product = DB::table('tblexpiration')->where('id', $id)->delete();
        return $product;
    }
}
