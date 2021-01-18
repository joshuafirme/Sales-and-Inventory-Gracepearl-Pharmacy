<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDiscount extends Model
{
    protected $table = 'tblorder_discount';
    protected $fillable = [
                            'id',
                            'order_no',
                            'discount_amount',
                            ];
}
