@extends('layouts.app')

@section('title', 'Blog - Prompt Dünyası')
@section('description', 'AI ve prompt dünyası hakkında en güncel yazılar ve rehberler')

@section('content')
    @include('components.breadcrumb', ['title' => 'Blog'])

    <div
        class="blog_style__one blog_classic_grid__style section_gap_y_bottom__1 section_gap_y_top__1 bg-body overflow-hidden">
        <div class="container py-5 ">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row gy-4">
                        @forelse($blogs as $blog)
                            <div class="col-md-6">
                                @include('components.blog-card', ['blog' => $blog])
                            </div>
                        @empty
                            <div class="col-12 text-center py-5">
                                <h5 class="text-muted">Henüz blog yazısı bulunamadı</h5>
                                <p class="text-muted">Yakında harika içeriklerle burada olacağız!</p>
                            </div>
                        @endforelse
                    </div>

                    @if(isset($blogs) && $blogs->hasPages())
                        <div class="d-flex justify-content-center mt-5">
                            {{ $blogs->links() }}
                        </div>
                    @endif
                </div>

                <div class="col-lg-4">
                    <aside class="blog__sidebar">
                        <div class="single__widget pt-0">
                            <h5 class="widget-title text-white">Popüler Yazılar</h5>
                            <ul class="widget__body popular__post">
                                @for($i = 1; $i <= 3; $i++)
                                    <li class="single_blog__sm d-flex mb-3">
                                        <div class="flex-shrink-0">
                                            <img
                                                src="{{ asset('assets/images/blog/b-' . ($i == 1 ? 'one' : ($i == 2 ? 'two' : 'three')) . '.png') }}"
                                                alt="Blog {{ $i }}" class="rounded"
                                                style="width: 60px; height: 60px; object-fit: cover;">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1 text-white">AI Prompt Yazma Rehberi {{ $i }}</h6>
                                            <small class="text-muted">{{ now()->subDays($i)->format('d.m.Y') }}</small>
                                        </div>
                                    </li>
                                @endfor
                            </ul>
                        </div>

                        <div class="widget">
                            <h5 class="widget-title text-white">Kategoriler</h5>
                            <div class="widget-content">
                                <ul class="list-unstyled">
                                    <li class="mb-2"><a href="#" class="text-decoration-none text-light">AI
                                            Rehberleri</a></li>
                                    <li class="mb-2"><a href="#" class="text-decoration-none text-light">Prompt
                                            Teknikleri</a></li>
                                    <li class="mb-2"><a href="#"
                                                        class="text-decoration-none text-light">Güncellemeler</a></li>
                                    <li class="mb-2"><a href="#" class="text-decoration-none text-light">İpuçları</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>
@endsection
