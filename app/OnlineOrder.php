<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnlineOrder extends Model
{
    protected $table = 'tblonline_order';
    protected $fillable = [
                            'id',
                            '_prefix',
                            'order_num',
                            'email',
                            'product_code',
                            'qty',
                            'amount',
                            'payment_method',
                            'status',
                            'shippingID'
                            ];
}
