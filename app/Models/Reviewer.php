<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reviewer extends Model
{
    protected $fillable = [
        'user_id',
        'journal_id',
        'email',
        'expertise',
        'specialization',
        'status',
        'review_format_file'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function journal(): BelongsTo
    {
        return $this->belongsTo(Journal::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
