<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['presentation_id', 'question'];

    public function presentation(): BelongsTo
    {
        return $this->belongsTo(Presentation::class);
    }
}
