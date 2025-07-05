<div class="collection_style__three bg-body section_gap_y_bottom__1 position-relative z-1">
    <div class="container">
        @include('components.section-header', [
            'subtitle' => 'En Popüler',
            'title' => 'Prompt Koleksiyonları',
            'showNavigation' => true,
            'prevClass' => 'collection__three_prev',
            'nextClass' => 'collection__three_next',
            'viewAllUrl' => '/',
            'viewAllText' => 'Tümü'
        ])

        <div class="collection_slider__two pt-40">
            <div class="swiper">
                <div class="swiper-wrapper">
                    @forelse($categories as $category)
                        @include('components.category-card', ['category' => $category])
                    @empty
                        <div class="swiper-slide">
                            <div class="collection_card_style__two">
                                <div class="collection_card__thumb">
                                    <img src="{{ asset('assets/images/collection/default.png') }}" alt="Kategori bulunamadı" class="w-100 h-100 object-cover">
                                </div>
                                <div class="collection_card__overlay">
                                    <span class="collection_btn">Kategori bulunamadı</span>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
                <div class="swiper-button-prev collection__three_prev"></div>
                <div class="swiper-button-next collection__three_next"></div>
            </div>
        </div>

        @push('scripts')
            <script src="{{ asset('assets/js/category-slider.js') }}"></script>
        @endpush
    </div>
</div>
