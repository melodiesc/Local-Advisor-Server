<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = ['owner_id', 'name', 'address', 'zip_code', 'city', 'category_id', 'description'];
}
