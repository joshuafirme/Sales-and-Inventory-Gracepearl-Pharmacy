<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\MyMail;

class MainCtr extends Controller
{
    public function sendMail()
    {
    	$data = array('name'=>"Gracepearl Testing",
                    'name'=>"Gracepearl Testing");

            Mail::to('rhealyncatapang@gmail.com')
                    ->send(new MyMail($data));
    }
}
