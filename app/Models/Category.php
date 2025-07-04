<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
        'cat_picture',
        'id'
    ];
    public function prompts()
{
    return $this->hasMany(Prompt::class, 'main_cat_id');
}
}
