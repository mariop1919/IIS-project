<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'equipment'];

    public function conferences(): BelongsToMany
    {
        return $this->belongsToMany(Conference::class, 'conference_room')
                    ->using(ConferenceRoom::class)  
                    ->withPivot('start_time', 'end_time')  
                    ->withTimestamps();
    }

    public function presentations(): HasMany
    {
        return $this->hasMany(Presentation::class);
    }
}
