@extends('layouts.app')

@section('title', $blog->title . ' - Blog')
@section('description', Str::limit(strip_tags($blog->content), 160))

@section('content')
    @include('components.breadcrumb', [
        'title' => $blog->title,
        'links' => [
            ['url' => route('blog.index'), 'title' => 'Blog']
        ]
    ])

    <div
        class="blog_style__one blog_classic_grid__style section_gap_y_bottom__1 section_gap_y_top__1 bg-body overflow-hidden">

        <div class="container py-5 bg-body">
            <div class="row">
                <div class="col-lg-8">
                    <article class="blog-post">
                        <div class="post-header mb-4">
                            <h1 class="post-title text-white">{{ $blog->title }}</h1>
                            <div class="post-meta text-muted">
                                <span><i class="bi bi-calendar"></i> {{ $blog->created_at->format('d.m.Y') }}</span>
                                <span class="ms-3"><i class="bi bi-person"></i> Admin</span>
                                <span class="ms-3"><i class="bi bi-eye"></i> {{ $blog->views ?? 0 }} görüntüleme</span>
                            </div>
                        </div>

                        @if($blog->featured_image)
                            <div class="post-image mb-4">
                                <img src="{{ $blog->featured_image }}" alt="{{ $blog->title }}"
                                     class="img-fluid rounded">
                            </div>
                        @endif

                        <div class="post-content text-light">
                            {!! $blog->content !!}
                        </div>

                        @if($blog->tags)
                            <div class="post-tags mt-4">
                                <h6>Etiketler:</h6>
                                @foreach(explode(',', $blog->tags) as $tag)
                                    <span class="badge bg-secondary me-2">{{ trim($tag) }}</span>
                                @endforeach
                            </div>
                        @endif
                    </article>

                    <div class="post-navigation mt-5">
                        <div class="row">
                            @if($previousPost)
                                <div class="col-md-6">
                                    <a href="{{ route('blog.show', $previousPost->slug) }}"
                                       class="text-decoration-none">
                                        <div class="nav-post prev-post">
                                            <small class="text-muted">Önceki Yazı</small>
                                            <h6>{{ $previousPost->title }}</h6>
                                        </div>
                                    </a>
                                </div>
                            @endif

                            @if($nextPost)
                                <div class="col-md-6 text-end">
                                    <a href="{{ route('blog.show', $nextPost->slug) }}" class="text-decoration-none">
                                        <div class="nav-post next-post">
                                            <small class="text-muted">Sonraki Yazı</small>
                                            <h6>{{ $nextPost->title }}</h6>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <aside class="blog-sidebar">
                        <div class="widget mb-4">
                            <h5 class="widget-title text-white">İlgili Yazılar</h5>
                            <div class="widget-content">
                                @forelse($relatedPosts as $post)
                                    <div class="d-flex mb-3">
                                        <div class="flex-shrink-0">
                                            <img
                                                src="{{ asset($post->featured_image ?? 'assets/images/blog/b-one.png') }}"
                                                alt="{{ $post->title }}" class="rounded"
                                                style="width: 60px; height: 60px; object-fit: cover;">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1">
                                                <a href="{{ route('blog.show', $post->slug) }}"
                                                   class="text-decoration-none text-white">
                                                    {{ $post->title }}
                                                </a>
                                            </h6>
                                            <small class="text-muted">{{ $post->created_at->format('d.m.Y') }}</small>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-muted">İlgili yazı bulunamadı.</p>
                                @endforelse
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>
@endsection
