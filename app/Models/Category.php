<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
        'cat_picture',
    ];

    public function prompts(): HasMany
    {
        return $this->hasMany(Prompt::class, 'main_cat_id');
    }
}
