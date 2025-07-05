@php
    $isArray = is_array($blog);
    $title = $isArray ? $blog['title'] : $blog->title;
    $image = $isArray ? $blog['image'] : ($blog->featured_image ?? 'assets/images/blog/default.png');
    $tag = $isArray ? $blog['tag'] : ($blog->tags ?? 'Blog');
    $writer = $isArray ? $blog['writer'] : 'Admin';
    $date = $isArray ? $blog['date'] : $blog->created_at->format('d.m.Y');
    $url = $isArray ? ($blog['slug'] ?? '#') : route('blog.show', $blog->slug ?? 'default');
@endphp

<div class="blog_card_style__one">
    <div class="blog__body">
        <div class="blog_thumb">
            <a href="{{ $url }}">
                <img src="{{ asset($image) }}" alt="{{ $title }}">
            </a>
        </div>
        <div class="blog_disc">
            <ul class="blog_meta">
                <li class="blog__tag"><a href="/">{{ $tag }}</a></li>
                <li class="blog__writer"><a href="/">{{ $writer }}</a></li>
                <li class="blog__date">{{ $date }}</li>
            </ul>
            <h5 class="blog__title">
                <a href="{{ $url }}">{{ $title }}</a>
            </h5>
        </div>
    </div>
    <a class="blog__btn" href="{{ $url }}" aria-label="{{ $title }} Detayları">
        <svg width="7" height="14" viewBox="0 0 7 14" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1 12.9658L5.59317 8.37172C6.13561 7.82916 6.13561 6.94135 5.59317 6.39879L1 1.80469"
                  stroke="currentColor" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"
                  stroke-linejoin="round"></path>
        </svg>
    </a>
</div>
