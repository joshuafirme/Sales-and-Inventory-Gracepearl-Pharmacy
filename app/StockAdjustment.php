<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockAdjustment extends Model
{
    protected $table = 'tblstockadjustment';
    protected $fillable = ['id', '_prefix', 'product_code', 'description', 'stock', 'action', 'qty_adjusted', 'remarks', 'created_at'];
}
