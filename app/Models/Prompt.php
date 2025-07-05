<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prompt extends Model
{
    protected $fillable = [
        'title',
        'main_cat_id',
        'other_cats',
        'picture',
        'prompt_agent',
        'used_times',
        'prompt_text',
        'publisher',
        'keywords',
    ];

    protected $casts = [
        'keywords' => 'array',
        'used_times' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'main_cat_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
