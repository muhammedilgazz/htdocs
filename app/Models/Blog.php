<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'featured_image',
        'tags',
        'status',
        'views',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'views' => 'integer',
    ];

    public function scopePublished(Builder $query): Builder
    {
        if (Schema::hasColumn('blogs', 'status')) {
            return $query->where('status', 'published')
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now());
        }
        return $query->latest();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
