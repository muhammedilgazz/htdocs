<?php

use App\Http\Controllers\{HomeController, PromptController};
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/collection', [PromptController::class, 'index'])->name('collection.index');
Route::resource('prompts', PromptController::class)->only(['create', 'store'])->names([
    'create' => 'prompt.create',
    'store' => 'prompt.store'
]);
