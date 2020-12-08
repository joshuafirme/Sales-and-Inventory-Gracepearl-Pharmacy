<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMaintenance extends Model
{
    protected $table = 'tblemployee';
    protected $fillable = [
        'id', '_prefix', 'name', 'username', 'password', 'auth_modules', 'position'
    ];
}
