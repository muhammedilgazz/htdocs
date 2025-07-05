@php
    $name = is_array($seller) ? $seller['name'] : $seller->name;
    $image = is_array($seller) ? $seller['image'] : ($seller->avatar ?? 'assets/images/sellers/default.png');
    $spend = is_array($seller) ? $seller['spend'] : '$1,954';
@endphp

<div class="seller_card_style__three">
    <div class="seller__thumb">
        <img src="{{ asset($image) }}" alt="{{ $name }}">
    </div>
    <div class="seller__disc">
        <h5 class="seller__name">{{ $name }}</h5>
        <span class="total__spend">{{ $spend }}</span>
    </div>
</div>
