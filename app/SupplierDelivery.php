<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplierDelivery extends Model
{
    protected $table = 'tblsupplier_delivery';
    protected $fillable = [ '_prefix',  'delivery_num', 'po_num', 'product_code', 'qty_delivered', 'exp_date', 'date_recieved', 'remarks'];
}
