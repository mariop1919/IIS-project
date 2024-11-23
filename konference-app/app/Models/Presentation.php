<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Presentation extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'photo' , 'start_time', 'end_time', 'status', 'conference_id', 'room_id', 'user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function conference(): BelongsTo
    {
        return $this->belongsTo(Conference::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function attendees(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_presentation');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function votedUsers()
    {
        return $this->belongsToMany(User::class, 'votes');
    }
}
