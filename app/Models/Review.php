<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'submission_id',
        'reviewer_id',
        'rating',
        'comments',
        'author_reply',
        'review_date',
        'editor_approved',
        'editor_edited_comments'
    ];

    protected $casts = [
        'review_date' => 'datetime',
        'editor_approved' => 'boolean',
    ];

    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(Reviewer::class);
    }
}
