<div class="swiper-slide">
    <div class="collection_card_style__two">
        <div class="collection_card__thumb">
            <img src="{{ asset($category->cat_picture ?? 'assets/images/collection/default.png') }}"
                 alt="{{ $category->description ?? 'Kategori' }}"
                 class="w-100 h-100 object-cover">
        </div>
        <div class="collection_card__overlay">
            <a class="collection_btn" href="/collection?category={{ $category->id }}">
                {{ $category->description ?? 'Kategori' }}
            </a>
        </div>
    </div>
</div>
