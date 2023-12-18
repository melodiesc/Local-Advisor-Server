<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'owner_id',
        'name',
        'address',
        'zip_code',
        'city',
        'category_id',
        'description',
        'image_path',
    ];
    
    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
