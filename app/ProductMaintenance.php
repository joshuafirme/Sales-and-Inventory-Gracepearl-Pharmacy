<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductMaintenance extends Model
{
    protected $table = 'tblproduct';
    protected $fillable = ['id', '_prefix', 'description', 'qty', 're_order', 'categoryID','supplierID', 'orig_price', 'selling_price', 'exp_date' , 'image'];
}
