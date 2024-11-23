<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = ['presentation_id', 'user_id'];
    
    public function presentation()
    {
        return $this->belongsTo(Presentation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}