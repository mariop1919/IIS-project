<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    // TO DO: delete 'is_activated' from the fillable array
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_activated',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',        
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function presentations() : HasMany
    {
        return $this->hasMany(Presentation::class);
    }

    public function conferences() : HasMany
    {
        return $this->hasMany(Conference::class);
    }

    public function reservations() : HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function attendingPresentations(): BelongsToMany
    {
        return $this->belongsToMany(Presentation::class, 'user_presentation');
    }
    public function votedPresentations()
    {
    return $this->belongsToMany(Presentation::class, 'votes')->withTimestamps();
    }
}
