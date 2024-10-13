<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    //use HasFactory;
    protected $fillable = ['name', 'description', 'location', 'capacity', 'price'];

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'conference_room')
                    ->using(ConferenceRoom::class)  
                    ->withPivot('start_time', 'end_time')  
                    ->withTimestamps();
    }
}
