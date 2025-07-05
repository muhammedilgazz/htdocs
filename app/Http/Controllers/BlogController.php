<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $blogs = Blog::published()
            ->latest()
            ->paginate(12);

        return view('blog.index', compact('blogs'));
    }

    public function show(string $slug): View
    {
        $blog = Blog::published()
            ->where('slug', $slug)
            ->firstOrFail();

        // Görüntüleme sayısını artır
        $blog->increment('views');

        // İlgili yazılar
        $relatedPosts = Blog::published()
            ->where('id', '!=', $blog->id)
            ->limit(3)
            ->latest()
            ->get();

        // Önceki ve sonraki yazılar
        $previousPost = Blog::published()
            ->where('id', '<', $blog->id)
            ->orderBy('id', 'desc')
            ->first();

        $nextPost = Blog::published()
            ->where('id', '>', $blog->id)
            ->orderBy('id', 'asc')
            ->first();

        return view('blog.show', compact('blog', 'relatedPosts', 'previousPost', 'nextPost'));
    }
}
