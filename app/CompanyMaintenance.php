<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyMaintenance extends Model
{
    protected $fillable = ['id', 'company_name', 'markup'];
}
