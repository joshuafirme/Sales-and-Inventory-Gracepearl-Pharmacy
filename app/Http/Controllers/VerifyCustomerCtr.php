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

        $fvc = $this->forValidationCustomer();

        if(request()->ajax())
        {
           
                return datatables()->of($fvc)
                ->addColumn('action', function($fvc){
                    $button = '<a class="btn btn-sm" id="btn-view-upload" customer-id='. $fvc->user_id .' data-toggle="modal" data-target="#verifyCustomerModal">
                    <i class="fas fa-eye"></i></a>';
    
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
           
        }
        return view('verifycustomer/verify_customer');
    }

    public function displayVerifiedCustomer(){
        $vc = $this->verifiedCustomer();

        if(request()->ajax())
        {
           
                return datatables()->of($vc)
                ->addColumn('action', function($vc){
                    $button = '<a class="btn btn-sm" id="btn-view-upload" customer-id='. $vc->user_id .' data-toggle="modal" data-target="#verifyCustomerModal">
                    <i class="fas fa-eye"></i></a>';
    
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
           
        }
    }

    public function forValidationCustomer(){

        $fvc = DB::table($this->tbl_cust_ver.' as CV')
        ->select('CV.*', 'fullname', 'phone_no', 'email',DB::raw('CONCAT('.$this->tbl_cust_acc.'._prefix, '.$this->tbl_cust_acc.'.id) as user_id'))
        ->leftJoin($this->tbl_cust_acc, 
        DB::raw('CONCAT('.$this->tbl_cust_acc.'._prefix, '.$this->tbl_cust_acc.'.id)'), '=', 'CV.user_id')
        ->where('status', 'For validation')
        ->orderBy('created_at', 'asc')
        ->get(); 

        return $fvc;
    }

    public function countValidationCustomer(){

        $fvc = $this->forValidationCustomer();

        return $fvc->count();
    }

    public function verifiedCustomer(){

        $verification_info = DB::table($this->tbl_cust_ver.' as CV')
        ->select('CV.*', 'fullname', 'phone_no', 'email',DB::raw('CONCAT(CA._prefix, CA.id) as user_id'))
        ->leftJoin($this->tbl_cust_acc.' as CA', DB::raw('CONCAT(CA._prefix, CA.id)'), '=', 'CV.user_id')
        ->where('status', 'Verified')
        ->orWhere('status', 'Verified SC/PWD')
        ->orderBy('created_at', 'asc')
        ->get(); 

        return $verification_info;
    }


    public function getVerificationInfo($cust_id){

        $verification_info = DB::table($this->tbl_cust_ver)
        ->select($this->tbl_cust_ver.'.*', 'fullname', 'phone_no', 'email', 'status')
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


    public function bulkVerified($user_ids){

        $user_ids_arr = explode(", ",$user_ids);

        for($i = 0; $i < count($user_ids_arr); $i++) {

            DB::table($this->tbl_cust_ver)
            ->where('user_id', $user_ids_arr[$i])
            ->update([
                'status' => 'Verified'
                ]);
        }
    }
    
}
