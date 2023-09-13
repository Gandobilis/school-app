<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recommendation extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'text', 'rating', 'author'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
