@extends('layouts.app')

@section('content')
    @include('components.breadcrumb', ['title' => $prompt->title])

    <div class="container py-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h1>{{ $prompt->title }}</h1>
                        <div class="mb-3">
                            <span class="badge bg-primary">{{ $prompt->category->description ?? 'Kategori' }}</span>
                            <span class="text-muted">{{ $prompt->used_times }} kez kullanıldı</span>
                        </div>

                        @if($prompt->picture)
                            <img src="{{ asset($prompt->picture) }}" alt="{{ $prompt->title }}" class="img-fluid mb-3">
                        @endif

                        <div class="prompt-text bg-light p-3 rounded">
                            <h5>Prompt Metni:</h5>
                            <p>{{ $prompt->prompt_text }}</p>
                        </div>

                        <div class="mt-3">
                            <button class="btn btn-primary" onclick="copyPrompt()">Kopyala</button>
                            <a href="{{ route('collection.index') }}" class="btn btn-secondary">Geri Dön</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5>Prompt Bilgileri</h5>
                        <p><strong>Yazar:</strong> {{ $prompt->user->name ?? 'Bilinmiyor' }}</p>
                        <p><strong>Kategori:</strong> {{ $prompt->category->description ?? 'Kategori' }}</p>
                        <p><strong>Oluşturulma:</strong> {{ $prompt->created_at->diffForHumans() }}</p>
                        @if($prompt->prompt_agent)
                            <p><strong>AI Model:</strong> {{ $prompt->prompt_agent }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyPrompt() {
            navigator.clipboard.writeText(`{{ $prompt->prompt_text }}`);
            alert('Prompt kopyalandı!');
        }
    </script>
@endsection
