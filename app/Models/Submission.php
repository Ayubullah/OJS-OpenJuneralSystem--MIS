<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Submission extends Model
{
    protected $fillable = [
        'article_id',
        'author_id',
        'submission_date',
        'status',
        'version_number',
        'file_path',
        'approval_pending_file',
        'approval_status',
        'plagiarism_percentage',
        'ai_report_file',
        'other_resources_report_file'
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected $casts = [
        'submission_date' => 'datetime',
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
