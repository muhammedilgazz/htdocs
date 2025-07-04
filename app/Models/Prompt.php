<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    public function category()
    {
        return $this->belongsTo(Category::class, 'main_cat_id');
    }
}
