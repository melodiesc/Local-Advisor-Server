<?php
namespace App\Models;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $table = 'notices';

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