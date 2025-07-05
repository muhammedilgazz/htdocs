@extends('layouts.app')

@section('content')
    @include('components.breadcrumb', ['title' => $categoryName ?? 'Prompt Koleksiyonu'])

    <div class="collection_style__three bg-body section_gap_y_bottom__1">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    @include('components.category-sidebar', ['categories' => $categories])
                </div>

                <div class="col-md-9">
                    @include('components.collection-header', [
                        'title' => $categoryName ?? 'Tüm Promptlar',
                        'count' => $prompts->count()
                    ])

                    <div class="row gy-4">
                        @forelse($prompts as $prompt)
                            <div class="col-lg-4 col-md-6">
                                @include('components.prompt-card', ['prompt' => $prompt])
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <h5 class="text-muted">Henüz prompt bulunamadı</h5>
                                    <p class="text-muted">Bu kategoride henüz hiç prompt eklenmemiş.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    @if($prompts->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $prompts->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
