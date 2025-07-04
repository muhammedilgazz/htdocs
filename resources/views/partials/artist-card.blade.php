{{-- Tek bir sanatçı kartı için partial --}}
<div class="artist_card_style__one">
    <div class="artist__thumb">
        <div class="artist__cover">
            <img src="{{ asset($artist['cover']) }}" alt="{{ $artist['name'] }} Kapak">
        </div>
        <div class="artist__avater">
            <img src="{{ asset($artist['avatar']) }}" alt="{{ $artist['name'] }} Avatar">
        </div>
    </div>
    <div class="artist__disc">
        <h6 class="artist__name">
            <a href="{{ $artist['url'] }}">{{ $artist['name'] }}</a>
        </h6>
        <button class="btn-follow" aria-label="{{ $artist['name'] }} Takip Et">
            <svg width="9" height="10" viewBox="0 0 9 10" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M1 5H8" stroke="currentColor" stroke-width="1.5"
                    stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M4.5 8.5V1.5" stroke="currentColor" stroke-width="1.5"
                    stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            Takip Et
        </button>
    </div>
</div>
<!-- Açıklama: $artist dizisi ['cover', 'avatar', 'name', 'url'] anahtarlarını içermelidir. -->
