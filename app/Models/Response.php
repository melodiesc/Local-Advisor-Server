<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Models\Notice;
use App\Models\Owner;

class Response extends Model
{
    protected $fillable = [
        'notice_id',
        'owner_id',
        'content',
    ];

    public function notice()
    {
        return $this->belongsTo(Notice::class, 'notice_id');
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }
}