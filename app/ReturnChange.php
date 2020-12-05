<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturnChange extends Model
{
    protected $table = 'tblreturn_change';
    protected $fillable = ['id', '_prefix', 'sales_inv_no', 'product_code', 'qty', 'action', 'product_code_changed', 'reason'];
}
