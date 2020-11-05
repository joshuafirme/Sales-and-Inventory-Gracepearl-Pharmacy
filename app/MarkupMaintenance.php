<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarkupMaintenance extends Model
{
    protected $table = 'tblmarkup';
    protected $fillable = ['id', 'supplierID', 'markup'];
}
