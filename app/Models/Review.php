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
        'plagiarism_percentage',
        'comments',
        'review_file',
        'author_reply',
        'review_date',
        'editor_approved',
        'editor_edited_comments',
        // General Comments - 6 Questions
        'originality_comment',
        'relationship_to_literature_comment',
        'methodology_comment',
        'results_comment',
        'implications_comment',
        'quality_of_communication_comment',
        // Strengths and Weaknesses
        'strengths',
        'weaknesses',
        // Suggestions for Improvement
        'suggestions_for_improvement',
        // Paper Score
        'relevance_score',
        'originality_score',
        'significance_score',
        'technical_soundness_score',
        'clarity_score',
        'documentation_score',
        'total_score',
        // Final Evaluation
        'final_evaluation',
        // Recommendation
        'recommendation'
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
