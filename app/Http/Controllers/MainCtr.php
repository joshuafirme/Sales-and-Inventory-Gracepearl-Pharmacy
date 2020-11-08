<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\MyMail;

class MainCtr extends Controller
{
    public function myDemoMail()
    {
    	$myEmail = 'rhealyncatapang@gmail.com';
    	Mail::to($myEmail)->send(new MyMail());

    	dd("Mail Send Successfully");
    }
}
