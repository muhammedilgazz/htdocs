<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    public function getAllWithPromptCount(): Collection
    {
        return Category::withCount('prompts')->get();
    }

    public function getPopularCategories(int $limit = 6): Collection
    {
        return Category::withCount('prompts')
            ->orderBy('prompts_count', 'desc')
            ->take($limit)
            ->get();
    }

    public function getCategoryWithPrompts(int $categoryId): ?Category
    {
        return Category::with(['prompts' => function ($query) {
            $query->latest()->take(10);
        }])->find($categoryId);
    }

    public function getCategoriesForNavigation(): Collection
    {
        return Category::select('id', 'name', 'description')->get();
    }
}
