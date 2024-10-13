<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    //use HasFactory;
    protected $fillable = ['name', 'capacity', 'equipment'];

    public function conferences()
    {
        return $this->belongsToMany(Conference::class, 'conference_room')
                    ->using(ConferenceRoom::class)  
                    ->withPivot('start_time', 'end_time')  
                    ->withTimestamps();
    }
}
