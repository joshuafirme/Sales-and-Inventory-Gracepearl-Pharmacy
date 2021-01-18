<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingAddressMaintenance extends Model
{
    protected $table = 'tblship_add_maintenance';
    protected $fillable = ['municipality', 'brgy', 'shipping_fee'];
}
