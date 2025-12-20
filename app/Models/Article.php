<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    protected $fillable = [
        'title',
        'journal_id',
        'author_id',
        'category_id',
        'manuscript_type',
        'abstract',
        'word_count',
        'number_of_tables',
        'number_of_figures',
        'previously_submitted',
        'funded_by_outside_source',
        'confirm_not_published_elsewhere',
        'confirm_prepared_as_per_guidelines',
        'status',
        'manuscript_file'
    ];

    public function journal(): BelongsTo
    {
        return $this->belongsTo(Journal::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }

    public function keywords(): BelongsToMany
    {
        return $this->belongsToMany(Keyword::class, 'article_keywords');
    }
}
