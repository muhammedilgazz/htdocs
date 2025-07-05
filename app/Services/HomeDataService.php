<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Prompt;
use App\Models\User;

class HomeDataService
{
    public function getHomeData(): array
    {
        \Log::info('Categories count: ' . Category::count());
        \Log::info('Users count: ' . User::count());
        \Log::info('Prompts count: ' . Prompt::count());


        return [
            'latestSellers' => User::latest()->take(4)->get(),
            'latestArtists' => User::latest()->take(6)->get(),
            'recentBlogs' => Blog::latest()->take(3)->get(),
            'prompts' => Prompt::latest()->get(),
            'categories' => Category::all()
        ];
    }

    public function getEmptyData(): array
    {
        return [
            'latestSellers' => collect(),
            'latestArtists' => collect(),
            'recentBlogs' => collect(),
            'prompts' => collect(),
            'categories' => collect()
        ];
    }
}
