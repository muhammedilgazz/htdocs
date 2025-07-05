@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Prompt Koleksiyonu</h1>

        <div class="row">
            <!-- Kategoriler -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        Kategoriler
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach($categories as $category)
                            <li class="list-group-item">
                                <a href="#{{ $category->slug }}">{{ $category->name }}</a>
                                <span class="badge bg-primary float-end">{{ $category->prompts_count ?? 0 }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Prompt Listesi -->
            <div class="col-md-9">
                <div class="row">
                    @forelse($prompts as $prompt)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <img src="{{ $prompt->image ?? asset('images/default-prompt.png') }}"
                                     class="card-img-top" alt="{{ $prompt->title }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $prompt->title }}</h5>
                                    <p class="card-text">{{ Str::limit($prompt->description, 100) }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted">{{ $prompt->created_at->diffForHumans() }}</span>
                                        <a href="{{ route('prompts.show', $prompt->id) }}"
                                           class="btn btn-sm btn-primary">İncele</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info">Henüz hiç prompt eklenmemiş.</div>
                        </div>
                    @endforelse
                </div>

                <!-- Sayfalama -->
                @if($prompts->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $prompts->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
