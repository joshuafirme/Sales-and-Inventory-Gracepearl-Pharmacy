<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryMaintenance extends Model
{
    protected $table = 'tblcategory';
    protected $fillable = ['id', 'category_name'];
}
