<div class="collection_style__three bg-body section_gap_y_bottom__1 position-relative z-1">
    <div class="container">
        <div class="row gy-4 align-items-end">
            <div class="col-lg-6">
                <span class="sub-header-2">En Popüler</span>
                <h2 class="section_title__2">Popüler Prompt Koleksiyonları</h2>
            </div>
            <div class="col-lg-6 d-flex justify-content-lg-end align-items-center">
                <div class="slider__nav d-flex mr-3">
                    <div class="collection__three_prev navigation_btn_2 btn__prev mr-1">
                        <i class="bi bi-chevron-left"></i>
                    </div>
                    <div class="collection__three_next navigation_btn_2 btn__next">
                        <i class="bi bi-chevron-right"></i>
                    </div>
                </div>
                <a class="btn-rounded-v3" href="/">
                    Tümü
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.25 6H11.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M6.25 1L11.25 6L6.25 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </a>
            </div>
        </div>

        <div class="collection_slider__two pt-40">
            <div class="swiper">
                <div class="swiper-wrapper">
                    @forelse($categories as $category)
                        <div class="swiper-slide">
                            <div class="collection_card_style__two">
                                <div class="collection_card__thumb">
                                    <img src="{{ asset('' . ($category->cat_picture ?? 'default.png')) }}" alt="{{ $category->description ?? 'Kategori' }}" class="w-100 h-100 object-cover">
                                </div>
                                <div class="collection_card__overlay">
                                    <a class="collection_btn" href="/collection?category={{ $category->id ?? '' }}">{{ $category->description ?? 'Kategori' }}</a>
                                </div>
                            </div>
                        </div>
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
                <!-- Swiper navigation -->
                <div class="swiper-button-prev collection__three_prev"></div>
                <div class="swiper-button-next collection__three_next"></div>
            </div>
        </div>

        <!-- Swiper başlatıcı -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                new Swiper('.collection_slider__two .swiper', {
                    slidesPerView: 4,
                    spaceBetween: 30,
                    navigation: {
                        nextEl: '.collection_slider__two .swiper-button-next',
                        prevEl: '.collection_slider__two .swiper-button-prev',
                    },
                    breakpoints: {
                        320: { slidesPerView: 1 },
                        768: { slidesPerView: 2 },
                        1024: { slidesPerView: 3 },
                        1200: { slidesPerView: 4 },
                    }
                });
            });
        </script>
    </div>
</div>