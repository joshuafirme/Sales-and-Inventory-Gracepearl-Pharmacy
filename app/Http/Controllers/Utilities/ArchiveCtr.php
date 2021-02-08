<?php

namespace App\Http\Controllers\Utilities;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArchiveCtr extends Controller
{
    public function index(){
        return view('utilities.archive');
    }
}
