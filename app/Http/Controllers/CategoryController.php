<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService)
    {
    }

    public function index(): View
    {
        return view('categories.index', [
            'categories' => $this->categoryService->getAllWithPromptCount()
        ]);
    }

    public function show(int $id): View
    {
        $category = $this->categoryService->getCategoryWithPrompts($id);

        if (!$category) {
            abort(404);
        }

        return view('categories.show', compact('category'));
    }
}
