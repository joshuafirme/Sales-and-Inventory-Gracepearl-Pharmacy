<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Input;

class VerifyCustomerCtr extends Controller
{
    private $tbl_cust_ver = "tblcustomer_verification";
    private $tbl_cust_acc = "tblcustomer_account";

    public function index(){

        $customer = $this->getCustomer();

        if(request()->ajax())
        {
           
                return datatables()->of($customer)
                ->addColumn('action', function($customer){
                    $button = '<a class="btn btn-sm" id="btn-view-upload" customer-id='. $customer->user_id .' data-toggle="modal" data-target="#verifyCustomerModal">
                    <i class="fas fa-eye"></i></a>';
    
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
           
        }
        return view('verifycustomer/verify_customer');
    }

    public function getCustomer(){

        $verification_info = DB::table($this->tbl_cust_ver)
        ->select($this->tbl_cust_ver.'.*', 'fullname', 'phone_no', 'email',DB::raw('CONCAT('.$this->tbl_cust_acc.'._prefix, '.$this->tbl_cust_acc.'.id) as user_id'))
        ->leftJoin($this->tbl_cust_acc, 
        DB::raw('CONCAT('.$this->tbl_cust_acc.'._prefix, '.$this->tbl_cust_acc.'.id)'), '=', $this->tbl_cust_ver . '.user_id')
        ->get(); 

        return $verification_info;
    }

    public function getVerificationInfo($cust_id){

        $verification_info = DB::table($this->tbl_cust_ver)
        ->select($this->tbl_cust_ver.'.*', 'fullname', 'phone_no', 'email')
        ->leftJoin($this->tbl_cust_acc, 
        DB::raw('CONCAT('.$this->tbl_cust_acc.'._prefix, '.$this->tbl_cust_acc.'.id)'), '=', $this->tbl_cust_ver . '.user_id')
        ->where('user_id', $cust_id)
        ->get(); 

        return $verification_info;
    }

    public function approve($cust_id){

        $id_type = Input::input('id_type');

        if($id_type == 'Senior Citizen ID' || $id_type == 'PWD ID'){
            DB::table($this->tbl_cust_ver)
            ->where('user_id', $cust_id)
            ->update([
                'status' => 'Verified SC/PWD'
            ]);
        }
        else{
            DB::table($this->tbl_cust_ver)
            ->where('user_id', $cust_id)
            ->update([
                'status' => 'Verified'
            ]);
        }  
    }

    public function decline($cust_id){

        DB::table($this->tbl_cust_ver)
        ->where('user_id', $cust_id)
        ->delete();                
    }
    
}
