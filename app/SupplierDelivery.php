<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplierDelivery extends Model
{
    protected $table = 'tblsupplier_delivery';
    protected $fillable = ['id', '_prefix', 'delivery_num', 'product_code', 'qty_delivered', 'exp_date', 'date_recieved', 'amount', 'status'];
}
