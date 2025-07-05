<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\Prompt;
use App\Models\User;

class HomeDataService
{
    public function __construct(
        private CategoryService    $categoryService,
        private TransformerService $transformer
    )
    {
    }

    public function getHomeData(): array
    {
        return [
            'latestSellers' => $this->getLatestSellers(),
            'latestArtists' => $this->getLatestArtists(),
            'recentBlogs' => $this->getRecentBlogs(),
            'prompts' => Prompt::latest()->take(8)->get(),
            'categories' => $this->categoryService->getPopularCategories(6) // 6 kategori getir
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

    private function getLatestSellers(): array
    {
        return User::latest()
            ->take(4)
            ->get()
            ->map(fn($user) => $this->transformer->toSeller($user))
            ->toArray();
    }

    private function getLatestArtists(): array
    {
        return User::latest()
            ->take(6)
            ->get()
            ->map(fn($user) => $this->transformer->toArtist($user))
            ->toArray();
    }

    private function getRecentBlogs(): array
    {
        return Blog::latest()
            ->take(3)
            ->get()
            ->map(fn($blog) => $this->transformer->toBlogData($blog))
            ->toArray();
    }
}
