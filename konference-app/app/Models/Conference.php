<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Conference extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'location', 'capacity', 'price'];

    public function rooms() : BelongsToMany
    {
        return $this->belongsToMany(Room::class, 'conference_room')
                    ->using(ConferenceRoom::class)  
                    ->withPivot('start_time', 'end_time')  
                    ->withTimestamps();
    }

    public function presentations() : HasMany
    {
        return $this->hasMany(Presentation::class);
    }
}
