{{-- Tek bir satıcı kartı için partial --}}
<div class="seller_card_style__three">
    <div class="seller__thumb">
        <img src="{{ asset($seller['image']) }}" alt="{{ $seller['name'] }}">
    </div>
    <div class="seller__disc">
        <h5 class="seller__name">
            <a href="{{ $seller['url'] }}">{{ $seller['name'] }}</a>
        </h5>
        <span class="total__spend">{{ $seller['spend'] }}</span>
    </div>
</div>
<!-- Açıklama: $seller dizisi ['image', 'name', 'url', 'spend'] anahtarlarını içermelidir. -->
