<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $table = 'tblpurchaseorder';
    protected $fillable = ['id', '_prefix', 'product_code', 'qty_order', 'amount'];
}
