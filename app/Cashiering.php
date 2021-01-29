<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cashiering extends Model
{
    protected $table = 'tblcashiering';
    protected $fillable = ['id', 'product_code', 'qty', 'amount'];
}
