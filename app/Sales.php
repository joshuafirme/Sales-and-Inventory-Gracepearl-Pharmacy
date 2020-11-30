<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $table = 'tblsales';
    protected $fillable = ['transactionNo', '_prefix', 'product_code', 'qty', 'amount', 'date', 'employeeID', 'order_from'];
}
