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
        $product = DB::table($this->tbl_prod.' AS P')
        ->select("P.*", DB::raw('CONCAT(P._prefix, P.id) AS product_code, unit, category_name, supplierName, DATE_FORMAT(exp_date,"%d-%m-%Y") as exp_date'))
        ->leftJoin($this->tbl_suplr.' AS S', 'S.id', '=', 'P.supplierID')
        ->leftJoin($this->tbl_cat.' AS C', 'C.id', '=', 'P.categoryID')
        ->leftJoin($this->tbl_unit.' AS U', 'U.id', '=', 'P.unitID')
        ->whereRaw('P.exp_date <= CURDATE()')
        ->get();

        return $product;
    }

    public function dispose($id)
    {
        $product = DB::table($this->tbl_prod)->where('id', $id)->delete();
        return $product;
    }
}
