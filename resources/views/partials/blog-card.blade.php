@php
    // Blog verilerini hazırlayan helper fonksiyon
    function prepareBlogData($blogItem) {
        $defaultImage = 'assets/images/blog/default.png';
        
        // Eğer URL zaten varsa doğrudan kullan
        if (is_array($blogItem) && isset($blogItem['url'])) {
            return [
                'title' => $blogItem['title'] ?? 'Başlık Yok',
                'image' => $blogItem['image'] ?? $defaultImage,
                'tag' => $blogItem['tag'] ?? 'Blog',
                'writer' => $blogItem['writer'] ?? 'Admin',
                'date' => $blogItem['date'] ?? now()->format('d.m.Y'),
                'url' => $blogItem['url']
            ];
        }
        
        // Handle object case
        return [
            'title' => $blogItem->title ?? 'Başlık Yok',
            'image' => $blogItem->featured_image ?? $defaultImage,
            'tag' => $blogItem->tags ?? 'Blog',
            'writer' => 'Admin',
            'date' => $blogItem->created_at->format('d.m.Y') ?? now()->format('d.m.Y'),
            'url' => route('blog.show', $blogItem->slug)
        ];
    }

    // Blog verilerini hazırla
    $blogData = prepareBlogData($blog);

    // SVG icon için sabit
    $arrowIconPath = 'M1 12.9658L5.59317 8.37172C6.13561 7.82916 6.13561 6.94135 5.59317 6.39879L1 1.80469';
@endphp

<div class="blog_card_style__one">
    <div class="blog__body">
        <div class="blog_thumb">
            <a href="{{ $blogData['url'] }}">
                <img src="{{ asset($blogData['image']) }}" alt="{{ $blogData['title'] }}">
            </a>
        </div>
        <div class="blog_disc">
            <ul class="blog_meta">
                <li class="blog__tag"><a href="/">{{ $blogData['tag'] }}</a></li>
                <li class="blog__writer"><a href="/">{{ $blogData['writer'] }}</a></li>
                <li class="blog__date">{{ $blogData['date'] }}</li>
            </ul>
            <h5 class="blog__title">
                <a href="{{ $blogData['url'] }}">{{ $blogData['title'] }}</a>
            </h5>
        </div>
    </div>
    <a class="blog__btn" href="{{ $blogData['url'] }}" aria-label="{{ $blogData['title'] }} Detayları">
        <svg width="7" height="14" viewBox="0 0 7 14" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="{{ $arrowIconPath }}" stroke="currentColor" stroke-width="2" stroke-miterlimit="10"
                  stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
    </a>
</div>
