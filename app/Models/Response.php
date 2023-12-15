<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Models\Notice;
use App\Models\Owner;

class Response extends Model
{
    // Define the relationship with Notice
    public function notice()
    {
        return $this->belongsTo(Notice::class, 'notice_id');
    }

    // Define the relationship with Owner
    public function owner()
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }
}