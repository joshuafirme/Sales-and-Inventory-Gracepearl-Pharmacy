<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerVerification extends Model
{
    protected $table = 'tblcustomer_verification';

    protected $fillable = [
        'id', 'user_id', 'id_type', 'valid_id_image', 'status'
    ];
}
