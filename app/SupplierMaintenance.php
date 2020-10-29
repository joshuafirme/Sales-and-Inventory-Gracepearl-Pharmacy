<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplierMaintenance extends Model
{
    protected $table = 'tblsupplier';
    protected $fillable = ['id, prefix, supplierName', 'address', 'person', 'contact'];
}
