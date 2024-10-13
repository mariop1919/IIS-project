<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConferenceRoom extends Model
{
    use HasFactory;
    protected $table = 'conference_room';
    protected $fillable = [
        'conference_id',
        'room_id',
        'start_time',
        'end_time',
    ];
    public function conference()
    {
        return $this->belongsTo(Conference::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
