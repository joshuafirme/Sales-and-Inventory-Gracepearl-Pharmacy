<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $table = 'tbldiscount';
    protected $fillable = ['id', 'discount'];
}
