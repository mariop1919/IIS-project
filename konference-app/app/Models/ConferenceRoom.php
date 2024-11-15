<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ConferenceRoom extends Pivot
{
    use HasFactory;
    protected $table = 'conference_room';
    protected $fillable = [
        'conference_id',
        'room_id',
        'start_time',
        'end_time',
    ];
    public function conference() : BelongsTo
    {
        return $this->belongsTo(Conference::class);
    }

    public function room() : BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
