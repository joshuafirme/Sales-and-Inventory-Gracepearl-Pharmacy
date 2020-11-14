<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyMaintenance extends Model
{
    protected $table = 'tblcompany';
    protected $fillable = ['id', 'company_name', 'markup'];
}
