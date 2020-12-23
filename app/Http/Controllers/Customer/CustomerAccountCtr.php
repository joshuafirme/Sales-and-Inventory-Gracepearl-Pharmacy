<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Input;
use App\CustomerAccount;
use App\CustomerVerification;

class CustomerAccountCtr extends Controller
{
    private $tbl_cust_acc = "tblcustomer_account";
    private $tbl_cust_ver = "tblcustomer_verification";

    public function index(){

        $acc_info = $this->getAccountInfo();
        return view('/customer/account',[
            'account' => $acc_info
        ]);
    }

    public function getAccountInfo(){

        $acc_info = DB::table($this->tbl_cust_acc)->where('email', session()->get('email'))->get(); 

        return $acc_info;
    }

    public function updateAccount(){

        $fullname = Input::input('fullname');
        $email = Input::input('email');
        $phone_no = Input::input('phone_no');

        CustomerAccount::where('email', $email)
        ->update([
            'fullname' => $fullname,
            'email' => $email,
            'phone_no' => $phone_no
            ]);

    }

    public function uploadID(Request $request){
        $user_id = $this->getUserID();
        $cust_verif = new CustomerVerification;
        $cust_verif->user_id = $user_id;
        $cust_verif->id_type = $request->input('id-type');
        $cust_verif->id_number = $request->input('id-number');
        $cust_verif->status = 'For validation';
        $cust_verif->save();

        if(request()->hasFile('image')){
            request()->validate([
                'image' => 'file|image|max:3000',
            ]);
        }

        $this->storeImage($user_id);

        return redirect('/account')->with('success', 'You have successfully uploaded your ID');
    }

    public function storeImage($user_id){
      
        if(request()->has('image')){
            CustomerVerification::where('user_id', $user_id)
       
            ->update([
                'image' => request()->image->store('uploads', 'public'),
            ]);
        }
    }

    public function isForValidation(){

        $user_id = $this->getUserID();
        
        if($user_id){
            $cust_ver =  DB::table($this->tbl_cust_ver)
            ->where('user_id', $user_id)
            ->value('status'); 

            if($cust_ver){
                if($cust_ver == 'For validation'){
                    return 'For validation';
                }
                else if($cust_ver == 'Verified'){
                    return 'Verified';
                }
                else{
                    return 'Verified Senior Citizen';
                }
            }  
            else{
                return null;
            } 
        }
     
    
       
    }

    public function getUserID(){
        $id =  DB::table($this->tbl_cust_acc)
                    ->where('email', session()->get('email'))
                    ->value('id');  
        return $id;
    }

}
