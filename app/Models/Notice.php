<?php
namespace App\Models;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;

    protected $table = 'notices';
    protected $fillable = [
        'location_id',
        'user_id',
        'comment',
        'rate'
    ];
    protected $primaryKey = 'notice_id';

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');

    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}