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
    private $tbl_ship_add = "tblshipping_add";

    public function index(){

        $acc_info = $this->getAccountInfo();
        $verification_info = $this->getVerificationInfo();
        $ship_info = $this->getShippingInfo();
        return view('/customer/account',[
            'account' => $acc_info,
            'verification' => $verification_info,
            'shipping' => $ship_info
        ]);
    }

    public function getAccountInfo(){

        $acc_info = DB::table($this->tbl_cust_acc)->where('email', session()->get('email'))->get(); 

        return $acc_info;
    }

    public function getVerificationInfo(){
        $user_id = $this->getUserIDWithPrefix();
        $verification_info = DB::table($this->tbl_cust_ver)->where('user_id', $user_id)->get(); 

        return $verification_info;
    }

    public function getShippingInfo(){
        $user_id = $this->getUserIDWithPrefix();
        $ship_info = DB::table($this->tbl_ship_add)->where('user_id', $user_id)->get(); 

        return $ship_info;
    }

    public function updateAccount(){

        $fullname = Input::input('fullname');
        $email = Input::input('email');
        $phone_no = Input::input('phone_no');

        $flr_bldg_blk = Input::input('flr_bldg_blk');
        $municipality = Input::input('municipality');
        $brgy = Input::input('brgy');
        $notes = Input::input('notes');

        CustomerAccount::where('email', $email)
        ->update([
            'fullname' => $fullname,
            'email' => $email,
            'phone_no' => $phone_no
            ]);

        $this->updateShippingAddress($flr_bldg_blk, $municipality, $brgy, $notes);
    }

    public function updateShippingAddress($flr_bldg_blk, $municipality, $brgy, $notes){

        $user_id = $this->getUserID();
        $user_id_prefix = $this->getUserIDWithPrefix();

        $shipping_add =  DB::table($this->tbl_ship_add)
        ->where('user_id', $user_id_prefix)->get();
        
        if($shipping_add->count() > 0){
            DB::table($this->tbl_ship_add)
            ->where('user_id', $user_id)
            ->update([
                'flr_bldg_blk' => $flr_bldg_blk,
                'municipality' => $municipality,
                'brgy' => $brgy,
                'note' => $notes
            ]);
        }
        else{
            DB::table($this->tbl_ship_add)
            ->insert([
                'user_id' => $user_id_prefix,
                'flr_bldg_blk' => $flr_bldg_blk,
                'municipality' => $municipality,
                'brgy' => $brgy,
                'note' => $notes
            ]);
        }
    }

    public function uploadID(Request $request){
        $user_id = $this->getUserIDWithPrefix();
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
                'image' => request()->image->store('customer-id-uploads', 'public'),
            ]);
        }
    }

    public function checkIfVerified(){

        $user_id = $this->getUserIDWithPrefix();
        
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
                    return 'Verified SC/PWD';
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

    public function getUserIDWithPrefix(){
        $id =  DB::table($this->tbl_cust_acc)
                    ->select(DB::raw('CONCAT('.$this->tbl_cust_acc.'._prefix, '.$this->tbl_cust_acc.'.id) as user_id'))
                    ->where('email', session()->get('email'))
                    ->first();  
        return $id->user_id;
    }
}
