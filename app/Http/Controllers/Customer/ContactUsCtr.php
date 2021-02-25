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
use Auth;

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
        return DB::table('tblcustomer_account')
        ->where('id', Auth::id())
        ->value('fullname');
    }

    public function getUserEmail()
    {
        return DB::table('tblcustomer_account')
                ->where('id', Auth::id())
                ->value('email'); 
     
    }

    public function getUserPhone()
    {
        return DB::table('tblcustomer_account')
                ->where('id', Auth::id())
                ->value('phone_no'); 
    }

}
