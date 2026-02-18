<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    protected $fillable = [
        'name',
        'email',
        'affiliation',
        'specialization',
        'orcid_id',
        'author_contributions',
        'created_at',
        'updated_at'
    ];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }
}
