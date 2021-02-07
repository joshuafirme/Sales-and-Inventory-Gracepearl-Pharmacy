<?php
namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Input;
use App\SupplierDelivery;
use App\Classes\UserAccessRights;

class SupplierDeliveryCtr extends Controller
{
    private $table_prod = "tblproduct";
    private $table_cat = "tblcategory";
    private $table_suplr = "tblsupplier";
    private $table_unit = "tblunit";
    private $table_stockad = "tblstockadjustment";
    private $table_po = "tblpurchaseorder";
    private $table_delivery = "tblsupplier_delivery";
    private $module = "Inventory";

    public function index()
    {
        $rights = new UserAccessRights;

        if(!($rights->isUserAuthorize($this->module)))
        {
            $rights->notAuthMessage();
        }
        return view('inventory/supplier_delivery',['getCurrentDate' => date('Y-m-d')]);
    }

    public function displayPurchaseOrder(){
        $po = $this->getPurchaseOrder();
        
        if(request()->ajax())
        {       
            return datatables()->of($po)
            ->addColumn('action', function($po){
                $button = '<a class="btn btn-sm" id="btn-add-delivery" product-code='. $po->product_code .' po-num='. $po->po_num .' 
                data-toggle="modal" data-target="#qtyDeliverModal" title="Add Delivery" style="color:#28A745;"><i class="fas fa-plus"></i></a>';

                return $button;
            })
            ->addColumn('status', function($po){
                if($po->status == 'Pending'){
                    $button = '<span class="badge" style="background-color:#337AB7; color:#fff;">Pending</span>';     
                    return $button;
                }
                return $button;
            })
            ->rawColumns(['action','status'])
            ->make(true);            
        }
    }

    public function displayDelivered(){
        $del = $this->getDelivery();
        
        if(request()->ajax())
        {       
            return datatables()->of($del)
            ->addColumn('remarks', function($del){
                if($del->remarks == 'Completed'){
                    $button = '<span class="badge badge-success">Completed</span>';     
                    return $button;
                }
                else if($del->remarks == 'Partially Completed'){
                    $button = '<span class="badge badge-warning">Partially Completed</span>';     
                    return $button;
                }
                else if($del->remarks == 'Pending'){
                    $button = '<span class="badge" style="background-color:#337AB7; color:#fff;">Pending</span>';     
                    return $button;
                }
            })
            ->rawColumns(['remarks'])
            ->make(true);            
        }
    }

    public function getPurchaseOrder()
     {
        $product = DB::table($this->table_po.' as PO')
        ->select("PO.*", 
        DB::raw('CONCAT(PO._prefix, PO.po_num) AS po_num, description, unit, supplierName, category_name, DATE_FORMAT(date,"%d-%m-%Y") as date'))
        ->leftJoin($this->table_prod.' as P',  DB::raw('CONCAT(P._prefix, P.id)'), '=', 'PO.product_code')
        ->leftJoin($this->table_suplr.' AS S', 'S.id', '=', 'P.supplierID')
        ->leftJoin($this->table_cat.' AS C', 'C.id', '=', 'P.categoryID')
        ->leftJoin($this->table_unit.' AS U', 'U.id', '=', 'P.unitID')
        ->where('status', ['Pending'])
        ->get();

        return $product;
     }
 

    public function recordDelivery(){
 
        $sd = new SupplierDelivery;
 
        $sd->_prefix = $this->getDeliveryNumPrefix();
        $sd->po_num = Input::input('po_num');
        $sd->product_code = Input::input('product_code');
        $sd->qty_delivered = Input::input('qty_delivered');
        $sd->exp_date = Input::input('exp_date');
        $sd->date_recieved = Input::input('date_recieved');
       
        $checked_result = $this->checkDeliveredQty($sd->product_code, $sd->qty_delivered);
      
        $sd->remarks = $checked_result;

        $sd->save();

        $this->updatePurchaseOrder($sd->po_num, $sd->product_code, $checked_result);
        $this->updateInventory($sd->product_code, $sd->qty_delivered, $sd->exp_date); 
       
    }

    public function updatePurchaseOrder($po_num, $product_code, $remarks){
        DB::table($this->table_po.' as PO')
            ->where('PO.product_code', '=', $product_code)
            ->where(DB::raw('CONCAT(PO._prefix, PO.po_num)'), '=', $po_num)
            ->update(
                ['PO.status' => $remarks]
            );
    }

    public function checkDeliveredQty($product_code, $qty_delivered){
        $qty_order = DB::table($this->table_po)
            ->where('product_code', $product_code)
            ->pluck('qty_order');

            if($qty_order > $qty_delivered){
                return 'Partially Completed';
            }
            if($qty_order == $qty_delivered){
                return 'Completed';
            }
            
          //  return $p;
    }

    public function updateInventory($product_code, $qty_delivered, $exp_date)
    {
        if($this->checkIfSameExpDate($product_code, $exp_date) == true)
        {
            DB::table('tblexpiration')
            ->where('product_code', $product_code)
            ->where('exp_date', $exp_date)
            ->update(array('qty' => DB::raw('qty + '. $qty_delivered .''))); 
        }
        else{
            DB::table('tblexpiration')->insert(
                [
                    'product_code' => $product_code,
                    'qty' => $qty_delivered,
                    'exp_date' => $exp_date
                ]
            );
        }
    }

    public function checkIfSameExpDate($product_code, $exp_date)
    {
        $res = DB::table('tblexpiration')
            ->where('product_code', $product_code)
            ->where('exp_date', $exp_date)
            ->get();
        if($res->count() > 0){
            return true;
        }
        else{
            return false;
        }
    
    }


     public function getDelivery()
     {
        $product = DB::table($this->table_delivery.' AS D')
        ->select("D.*", 
        DB::raw('CONCAT(D._prefix, D.delivery_num) 
        AS del_num, description, supplierName, category_name, unit, qty_order,  DATE_FORMAT(D.exp_date,"%d-%m-%Y") as exp_date, DATE_FORMAT(date_recieved,"%d-%m-%Y") as date_recieved'))
        ->leftJoin($this->table_prod.' AS P',  DB::raw('CONCAT(P._prefix, P.id)'), '=', 'D.product_code')
        ->leftJoin($this->table_po.' AS PO', 'PO.product_code', '=', 'D.product_code')
        ->leftJoin($this->table_suplr.' AS S', 'S.id', '=', 'P.supplierID')
        ->leftJoin($this->table_cat.' AS C', 'C.id', '=', 'P.categoryID')
        ->leftJoin($this->table_unit.' AS U', 'U.id', '=', 'P.unitID')
        ->orderBy('D.delivery_num', 'desc')
        ->get();

        return $product;
     }

     
     public function show()
     {
         $product_code = Input::input('product_code');
         $po_num = Input::input('po_num');

         $po = DB::table($this->table_po.' as PO')
             ->select("PO.*", DB::raw('CONCAT(PO._prefix, PO.po_num) AS po_num, description, supplierName, category_name, unit'))
             ->leftJoin($this->table_prod.' as P',  DB::raw('CONCAT(P._prefix, P.id)'), '=', 'PO.product_code')
             ->leftJoin($this->table_suplr.' AS S', 'S.id', '=', 'P.supplierID')
             ->leftJoin($this->table_cat.' AS C', 'C.id', '=', 'P.categoryID')
             ->leftJoin($this->table_unit.' AS U', 'U.id', '=', 'P.unitID')
             ->where([
                 ['PO.product_code', $product_code],
                 [DB::raw('CONCAT(PO._prefix, PO.po_num)'), $po_num]
                 ])
             ->get();
 
             return $po;
     }

    public function markAsCompleted($del_nums){

        $del_num_arr = explode(", ",$del_nums);

        for($i = 0; $i < count($del_num_arr); $i++) {

            DB::table($this->table_delivery)
            ->where(DB::raw('CONCAT('.$this->table_delivery.'._prefix, '.$this->table_delivery.'.delivery_num)'), $del_num_arr[$i])
            ->update([
                'remarks' => 'Completed'
                ]);
        }
    }

    public function getQtyOrdered(){
        $po_num = DB::table($this->table_po)
        ->where('po_num');
        $inc = ++ $po_num;
        return $inc;
    }


    public function getDeliveryNumPrefix(){
        return 'D' . date('m') . date('d');
    }

    
}
