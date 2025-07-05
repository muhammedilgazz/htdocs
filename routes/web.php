<?php

use App\Http\Controllers\{HomeController, PromptController, CategoryController, BlogController};
use Illuminate\Support\Facades\Route;

// Ana sayfa route'u
Route::get('/', [HomeController::class, 'index'])->name('home');

// Prompt ile ilgili route'lar
Route::get('/collection', [PromptController::class, 'index'])->name('collection.index');
Route::get('/prompt/{prompt}', [PromptController::class, 'show'])->name('prompt.show');
Route::prefix('prompts')->group(function () {
    Route::get('/create', [PromptController::class, 'create'])->name('prompt.create');
    Route::post('/', [PromptController::class, 'store'])->name('prompt.store');
});

// Kategori route'ları
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/{category}', [CategoryController::class, 'show'])->name('categories.show');
});

// Blog route'ları
Route::prefix('blog')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/{blog:slug}', [BlogController::class, 'show'])->name('blog.show');
});
