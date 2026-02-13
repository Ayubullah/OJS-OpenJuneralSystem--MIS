<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EditorMessage extends Model
{
    protected $fillable = [
        'article_id',
        'submission_id',
        'editor_id',
        'sender_type',
        'author_id',
        'reviewer_id',
        'editor_recipient_id',
        'message',
        'recipient_type',
        'is_approval_request'
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class);
    }

    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'editor_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(Reviewer::class);
    }

    public function editorRecipient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'editor_recipient_id');
    }

    /**
     * Get the attributes that should be cast.
     */
    protected $casts = [
        'is_approval_request' => 'boolean',
    ];
}

