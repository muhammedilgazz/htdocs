{{-- Tek bir blog kartı için partial --}}
<div class="blog_card_style__one">
    <div class="blog__body">
        <div class="blog_thumb"><img src="{{ asset($blog['image']) }}" alt="{{ $blog['title'] }}"></div>
        <div class="blog_disc">
            <ul class="blog_meta">
                <li class="blog__tag"><a href="/">{{ $blog['tag'] }}</a></li>
                <li class="blog__writer"><a href="/">{{ $blog['writer'] }}</a></li>
                <li class="blog__date">{{ $blog['date'] }}</li>
            </ul>
            <h5 class="blog__title"><a href="{{ $blog['url'] }}">{{ $blog['title'] }}</a></h5>
        </div>
    </div>
    <a class="blog__btn" href="{{ $blog['detail_url'] }}" aria-label="{{ $blog['title'] }} Detayları">
        <svg width="7" height="14" viewBox="0 0 7 14" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1 12.9658L5.59317 8.37172C6.13561 7.82916 6.13561 6.94135 5.59317 6.39879L1 1.80469" stroke="currentColor" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
    </a>
</div>
<!-- Açıklama: $blog dizisi ['image', 'title', 'tag', 'writer', 'date', 'url', 'detail_url'] anahtarlarını içermelidir. -->
