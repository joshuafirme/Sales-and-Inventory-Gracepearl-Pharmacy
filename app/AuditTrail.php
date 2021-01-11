<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuditTrail extends Model
{
    protected $table = 'tblaudit_trail';
    protected $fillable = ['id', 'user_name', 'module', 'action'];
}
