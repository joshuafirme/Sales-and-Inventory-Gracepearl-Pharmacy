<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Input;
use Mail;
use Session;
use App\Mail\ContactUs;
use App\CustomerAccount;

class ContactUsCtr extends Controller
{
    private $tbl_cust_acc = "tblcustomer_account";

    public function index()
    {
        return view('customer.contact-us', [
            'fullname' => $this->getUserFullname(),
            'email' => $this->getUserEmail(),
            'phone_no' => $this->getUserPhone()
        ]);
    }

    public function sendMessage()
    {
        $email = Input::input('email');
        $fullname = Input::input('fullname');
        $body = Input::input('message');
        $phone_no = Input::input('phone_no');

        $message =  "<p>From: " . $email  . "</p>" .
                    "<p>Name: " . $fullname  . "</p>" . 
                    "<p>Message: " . $body . "</p>" . 
                    "<p>Phone number: " . $phone_no . "</p>";

        Mail::to('admin@gracepearlpharmacy.com')->send(new ContactUs($message));
    }

    public function getUserFullname()
    {
        $user_id = $this->getUserID();
        if($user_id)
        {
            return DB::table('tblcustomer_account')
                    ->where('id', )
                    ->value('fullname'); 
        }
        else{
            return "";
        }
    }

    public function getUserEmail()
    {
       $user_id = $this->getUserID();
        if($user_id)
        {
            return DB::table('tblcustomer_account')
                    ->where('id', )
                    ->value('email'); 
        }
        else{
            return "";
        }
    }

    public function getUserPhone()
    {
         $user_id = $this->getUserID();
        if($user_id)
        {
            return DB::table('tblcustomer_account')
                    ->where('id', )
                    ->value('phone_no'); 
        }
        else{
            return "";
        }
    }

   public function getUserID(){
        $session_phone_no = session()->get('phone_no');
        $session_email = session()->get('email');

        if($session_phone_no){
            $id =  DB::table($this->tbl_cust_acc)
            ->where('phone_no', $session_phone_no)
            ->value('id');  
        }
        else if($session_email){
            $id =  DB::table($this->tbl_cust_acc)
            ->where('email', $session_email)
            ->value('id'); 
        }
        
        return null;
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
        }
        else if($session_email){
          $id =  DB::table($this->tbl_cust_acc)
          ->select(DB::raw('CONCAT('.$this->tbl_cust_acc.'._prefix, '.$this->tbl_cust_acc.'.id) as user_id'))
          ->where('email', $session_email)    
          ->first();  
        }
        
        return $id->user_id;
    }
}
