@extends('layouts.app')

@section('content')
    @include('components.breadcrumb', ['title' => 'Kategoriler'])

    <div class="container py-4">
        <div class="row gy-4">
            @forelse($categories as $category)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card h-100">
                        <div class="card-img-top"
                             style="height: 200px; background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);"></div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $category->description ?? $category->name }}</h5>
                            <p class="text-muted">{{ $category->prompts_count }} prompt</p>
                            <a href="{{ route('categories.show', $category->id) }}" class="btn btn-primary btn-sm">
                                Görüntüle
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <h5 class="text-muted">Henüz kategori bulunamadı</h5>
                </div>
            @endforelse
        </div>
    </div>
@endsection
