<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'image',
        'tag',
        'writer',
        'date',
        'url',
        'detail_url',
    ];
}
