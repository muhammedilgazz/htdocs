@extends('layouts.app')

@section('content')
    @include('components.breadcrumb', ['title' => $category->description ?? $category->name])

    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <h2>{{ $category->description ?? $category->name }}</h2>
                <p class="text-muted mb-4">{{ $category->prompts->count() }} prompt bulundu</p>
            </div>
        </div>

        <div class="row gy-4">
            @forelse($category->prompts as $prompt)
                <div class="col-lg-4 col-md-6">
                    @include('components.prompt-card', ['prompt' => $prompt])
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <h5 class="text-muted">Bu kategoride henüz prompt bulunamadı</h5>
                    <a href="{{ route('collection.index') }}" class="btn btn-primary">Tüm Promptları Görüntüle</a>
                </div>
            @endforelse
        </div>
    </div>
@endsection
