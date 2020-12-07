<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Input;
use App\SupplierDelivery;

class SupplierDeliveryCtr extends Controller
{
    private $table_prod = "tblproduct";
    private $table_cat = "tblcategory";
    private $table_suplr = "tblsupplier";
    private $table_unit = "tblunit";
    private $table_stockad = "tblstockadjustment";
    private $table_po = "tblpurchaseorder";
    private $table_delivery = "tblsupplier_delivery";

    public function index()
    { 

        return view('inventory/supplier_delivery',['getCurrentDate' => date('yy-m-d')]);
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
                else if($del->remarks == 'Partial'){
                    $button = '<span class="badge badge-warning">Partial</span>';     
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
        $product = DB::table($this->table_po)
        ->select("tblpurchaseorder.*", 
        DB::raw('CONCAT('.$this->table_po.'._prefix, '.$this->table_po.'.po_num) AS po_num, description, unit, supplierName, category_name, DATE_FORMAT(date,"%d-%m-%Y") as date'))
        ->leftJoin($this->table_prod,  DB::raw('CONCAT('.$this->table_prod.'._prefix, '.$this->table_prod.'.id)'), '=', $this->table_po . '.product_code')
        ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
        ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
        ->leftJoin($this->table_unit, $this->table_unit . '.id', '=', $this->table_prod . '.unitID')
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

             $checked_result = $this->checkDeliveredQty($sd->product_code, $sd->qty_delivered );
             $sd->remarks = $checked_result;
             $sd->save();

           //  $checked_result = $this->checkDeliveredQty($sd->product_code, $sd->remarks);
             $this->updatePurchaseOrder($sd->po_num, $sd->product_code, $checked_result);
     
     }

     public function updatePurchaseOrder($po_num, $product_code, $remarks){
        DB::table($this->table_po)
            ->where('product_code', $product_code)
            ->update(['status' => $remarks]);
    }

    public function checkDeliveredQty($product_code, $qty_delivered){
        $qty_order = DB::table($this->table_po)
            ->where('product_code', $product_code)
            ->value('qty_order');

            if($qty_order > $qty_delivered){
                $p = 'Partial';
            }
            else if($qty_order == $qty_delivered){
                $p = 'Completed';
            }
            
            return $p;
    }


     public function getDelivery()
     {
        $product = DB::table($this->table_delivery)
        ->select("tblsupplier_delivery.*", 
        DB::raw('CONCAT('.$this->table_delivery.'._prefix, '.$this->table_delivery.'.delivery_num) 
        AS del_num, description, supplierName, category_name, unit, qty_order,  DATE_FORMAT(tblsupplier_delivery.exp_date,"%d-%m-%Y") as exp_date, DATE_FORMAT(date_recieved,"%d-%m-%Y") as date_recieved'))
        ->leftJoin($this->table_prod,  DB::raw('CONCAT('.$this->table_prod.'._prefix, '.$this->table_prod.'.id)'), '=', $this->table_delivery. '.product_code')
        ->leftJoin($this->table_po,  $this->table_po.'.product_code', '=', $this->table_delivery. '.product_code')
        ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
        ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
        ->leftJoin($this->table_unit, $this->table_unit . '.id', '=', $this->table_prod . '.unitID')
        ->get();

        return $product;
     }

     
     public function show()
     {
         $product_code = Input::input('product_code');
         $po_num = Input::input('po_num');
         $po = DB::table($this->table_po)
             ->select("tblpurchaseorder.*", DB::raw('CONCAT(tblpurchaseorder._prefix, tblpurchaseorder.po_num) AS po_num, description, supplierName, category_name, unit'))
             ->leftJoin($this->table_prod,  DB::raw('CONCAT('.$this->table_prod.'._prefix, '.$this->table_prod.'.id)'), '=', $this->table_po . '.product_code')
             ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
             ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
             ->leftJoin($this->table_unit, $this->table_unit . '.id', '=', $this->table_prod . '.unitID')
             ->where([
                 ['tblpurchaseorder.product_code', $product_code],
                 [DB::raw('CONCAT(tblpurchaseorder._prefix, tblpurchaseorder.po_num)'), $po_num]
                 ])
             ->get();
 
             return $po;
     }


    public function getDeliveryNumPrefix(){
        return 'D' . $this->getMonth() . $this->getDay();
    }

    public function getDate(){
        return $date = $this->getYear() . $this->getMonth() . $this->getDay();
    }

    public function getYear(){
        return $year = date('y');
    }

    public function getMonth(){
        return $month = date('m');
    }

    public function getDay(){
        return $month = date('d');
    }
}
