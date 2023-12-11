<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bar extends Model
{
    protected $fillable = ['owner_id', 'name', 'address', 'zip_code', 'city', 'category_id', 'description'];
}
