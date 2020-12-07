<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturnChange extends Model
{
    protected $table = 'tblreturn_change';
    protected $fillable = ['id', 'sales_inv_no', 'product_code', 'qty', 'reason', 'date'];
}
