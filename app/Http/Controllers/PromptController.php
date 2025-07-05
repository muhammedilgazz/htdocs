<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePromptRequest;
use App\Models\Category;
use App\Models\Prompt;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PromptController extends Controller
{
    public function index(): View
    {
        return view('collection.index', [
            'prompts' => Prompt::latest()->get(),
            'categories' => Category::with('prompts')->get()
        ]);
    }

    public function create(): View
    {
        return view('prompts.create', [
            'categories' => Category::all()
        ]);
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
