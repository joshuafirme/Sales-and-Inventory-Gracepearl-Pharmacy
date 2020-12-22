<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoogleAccount extends Model
{
  

    protected $table = 'tblgoogle_account';

    protected $fillable = [
        'id', 'fullname', 'phone_no', 'shipping_address_id', 'email'
    ];

}
