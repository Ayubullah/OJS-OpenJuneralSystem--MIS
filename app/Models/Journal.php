<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Journal extends Model
{
    protected $fillable = [
        'name',
        'issn',
        'description',
        'status'
    ];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function issues(): HasMany
    {
        return $this->hasMany(Issue::class);
    }
}
