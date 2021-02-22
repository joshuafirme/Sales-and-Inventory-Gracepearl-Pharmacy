<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Input;
use Mail;
use Session;
use App\Mail\EmailVerification;
use App\CustomerAccount;
use App\CustomerVerification;
use App\Classes\BrgyAPI;
use Redirect;

class CustomerAccountCtr extends Controller
{
    private $tbl_cust_acc = "tblcustomer_account";
    private $tbl_cust_ver = "tblcustomer_verification";
    private $tbl_ship_add = "tblshipping_add";
    private $tbl_ship_add_maintenance = "tblship_add_maintenance";

    public function index(){
        $this->isLoggedIn();
        $acc_info = $this->getAccountInfo();
        $verification_info = $this->getVerificationInfo();
        $ship_info = $this->getShippingInfo();
        $municipality = $this->getMunicipalityList();


        return view('/customer/account',[
            'account' => $acc_info,
            'verification' => $verification_info,
            'shipping' => $ship_info,
            'municipality' => $municipality
        ]);
    }

    public function isLoggedIn(){
        if(session()->get('is-customer-logged') !== 'yes'){
   
           return redirect()->to('/customer-login')->send();
        }
    }

    public function getAccountInfo()
    {
        $session_phone_no = session()->get('phone_no');
        $session_email = session()->get('email');

        if($session_phone_no){
            $acc_info = DB::table($this->tbl_cust_acc)
                    ->where('phone_no', session()->get('phone_no'))
                    ->get(); 
        }
        else{
            $acc_info = DB::table($this->tbl_cust_acc)
            ->where('email', $session_email)
            ->get(); 
        }
       

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

    public function updateAccount()
    {
        $user_id = $this->getUserID();
        $fullname = Input::input('fullname');
        $email = Input::input('email');
        $phone_no = Input::input('phone_no');

        $flr_bldg_blk = Input::input('flr_bldg_blk');
        $municipality = Input::input('municipality');
        $brgy = Input::input('brgy');
        $notes = Input::input('notes');

        CustomerAccount::where('id', $user_id)
        ->update([
            'fullname' => $fullname,
            'email' => $email,
            'phone_no' => $phone_no
            ]);

        $this->updateShippingAddress($flr_bldg_blk, $municipality, $brgy, $notes);
    }

    public function updateShippingAddress($flr_bldg_blk, $municipality, $brgy, $notes){

    //    $user_id = $this->getUserID();
        $user_id_prefix = $this->getUserIDWithPrefix();

        $shipping_add =  DB::table($this->tbl_ship_add)->where('user_id', $user_id_prefix)->get();

        if($shipping_add->count() > 0){
            DB::table($this->tbl_ship_add)
            ->where('user_id', $user_id_prefix)
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

// Change Password-----------------------------------------------------------------------------------------------------------------------------------------------------------------------

    public function change_password_view()
    {
        $this->isLoggedIn();
        return view('customer.change-password',[
            'email' => $this->getUserEmail(),
            'phone_no' => $this->getUserPhoneNo()
        ]);
    }


    public function sendEmailVerificationCode($email)
    {
        $vcode = rand(1000,9999);
        $message = "Your verification code is ". $vcode ." from Gracepearl Pharmacy";

        Mail::to($email)->send(new EmailVerification($message));
        Session::put('vcode', $vcode);
    }

    public function sendSMSVerificationCode($phone_no)
    {
        $basic  = new \Nexmo\Client\Credentials\Basic('a08cdaef', '9cXwHtJotgmRww3t');
        $client = new \Nexmo\Client($basic);

        $vcode = rand(1000,9999);
      
        $message = $client->message()->send([
            'to' => '63'.$phone_no,
            'from' => 'Gracepearl Pharmacy',
            'text' => "Your verification code is ". $vcode ." from Gracepearl Pharmacy"
        ]);

        Session::put('vcode', $vcode);
    }

    public function validateOTP($vcode)
    {
        if(Session::get('vcode') == $vcode){
            return '1';
        }
        else{
            return '0';
        }
    }

    public function updatePassword($password)
    {         
        $user_id = $this->getUserID();  
        $hashed = Hash::make($password);

        DB::table('tblcustomer_account')
            ->where('id', $user_id)
            ->update([
                'password' => $hashed
            ]);

        Session::forget('vcode');
      //  return Redirect::to('/account/change-password')->with('success', 'Your password is updated successfully');
    }

//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// Change email-----------------------------------------------------------------------------------------------------------------------------------------------------------------------

public function change_email_view()
{
    $this->isLoggedIn();
    return view('customer.change-email',[
        'email' => $this->getUserEmail(),
        'phone_no' => $this->getUserPhoneNo()
    ]);
}

public function updateEmail($email)
{         
    $user_id = $this->getUserID();  

    DB::table('tblcustomer_account')
        ->where('id', $user_id)
        ->update([
            'email' => $email
        ]);

    Session::forget('vcode');
}   
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// Change contact number-----------------------------------------------------------------------------------------------------------------------------------------------------------------------

public function change_contact_view()
{
    $this->isLoggedIn();
    return view('customer.change-contact',[
        'email' => $this->getUserEmail(),
        'phone_no' => $this->getUserPhoneNo()
    ]);
}

public function updatePhoneNo($phone_no)
    {         
        $user_id = $this->getUserID();  

        DB::table('tblcustomer_account')
            ->where('id', $user_id)
            ->update([
                'phone_no' => $phone_no
            ]);

        Session::forget('vcode');
    }
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

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
                switch ($cust_ver) {
                    case 'Verified':
                        return 'Verified';
                        break;
                    case 'Verified Senior Citizen':
                        return 'Verified Senior Citizen';
                        break; 
                    case 'Verified PWD':
                        return 'Verified PWD';
                        break; 
                    default:
                      return 'For validation';
                  }
            }  
            else{
                return null;
            } 
        }      
    }

    
    public function getMunicipalityList()
    {
        $municipality = DB::table($this->tbl_ship_add_maintenance)
                ->get(); 
        return $municipality->unique('municipality');
    }

    public function getBrgyList($municipality)
    {
        $brgy = DB::table($this->tbl_ship_add_maintenance)
                ->where('municipality', $municipality)
                ->get(); 
        return $brgy;
    }

    public function getUserEmail()
    {
        return DB::table('tblcustomer_account')
                ->where('id', $this->getUserID())
                ->value('email'); 
    }

    public function getUserPhoneNo()
    {
        return DB::table('tblcustomer_account')
                ->where('id', $this->getUserID())
                ->value('phone_no'); 
    }

    public function getUserID(){
        $session_phone_no = session()->get('phone_no');
        $session_email = session()->get('email');

        if($session_phone_no){
            $id =  DB::table($this->tbl_cust_acc)
            ->where('phone_no', $session_phone_no)
            ->value('id');  
            return $id;
        }
        else{
            $id =  DB::table($this->tbl_cust_acc)
            ->where('email', $session_email)
            ->value('id');  
            return $id;
        }
       
    }

    public function getUserIDWithPrefix()
    {
        $session_phone_no = session()->get('phone_no');
        $session_email = session()->get('email');

        if($session_phone_no){
            $id =  DB::table($this->tbl_cust_acc)
            ->select(DB::raw('CONCAT('.$this->tbl_cust_acc.'._prefix, '.$this->tbl_cust_acc.'.id) as user_id'))
            ->where('phone_no', $session_phone_no)    
            ->first();  
            return $id->user_id;
        }
        else{
          $id =  DB::table($this->tbl_cust_acc)
          ->select(DB::raw('CONCAT('.$this->tbl_cust_acc.'._prefix, '.$this->tbl_cust_acc.'.id) as user_id'))
          ->where('email', $session_email)    
          ->first();  
          return $id->user_id;
        }
    }
}
