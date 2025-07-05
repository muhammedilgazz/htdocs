<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePromptRequest;
use App\Models\Prompt;
use App\Services\CategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PromptController extends Controller
{
    public function __construct(private CategoryService $categoryService)
    {
    }

    public function index(): View
    {
        $query = Prompt::with(['category', 'user']);

        // Kategori filtresi
        if (request('category')) {
            $query->where('main_cat_id', request('category'));
        }

        // Sıralama
        $sort = request('sort', 'newest');
        switch ($sort) {
            case 'popular':
                $query->orderBy('used_times', 'desc');
                break;
            case 'liked':
                $query->orderBy('likes', 'desc');
                break;
            case 'used':
                $query->orderBy('used_times', 'desc');
                break;
            default:
                $query->latest();
        }

        $prompts = $query->paginate(12);
        $categories = $this->categoryService->getAllWithPromptCount();
        $categoryName = request('category') ?
            $this->categoryService->getCategoryWithPrompts(request('category'))?->description : null;

        return view('collection.index', compact('prompts', 'categories', 'categoryName'));
    }

    public function create(): View
    {
        return view('prompts.create', [
            'categories' => $this->categoryService->getCategoriesForNavigation()
        ]);
    }

    public function show(Prompt $prompt): View
    {
        $prompt->load(['category', 'user', 'tags']);
        $prompt->increment('used_times');

        return view('prompts.show', compact('prompt'));
    }

    public function store(StorePromptRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('picture')) {
            $data['picture'] = $request->file('picture')->store('prompt_images', 'public');
        }

        $data['publisher'] = auth()->id();

        Prompt::create($data);

        return redirect()
            ->route('collection.index')
            ->with('success', 'Prompt başarıyla oluşturuldu!');
    }
}
