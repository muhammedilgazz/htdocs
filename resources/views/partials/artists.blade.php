<div class="artists_style__one bg-body section_gap_y_bottom__1">
    <div class="container">
        @include('components.section-header', [
            'title' => 'Öne Çıkan Prompt Yazarları',
            'subtitle' => '',
            'description' => 'En popüler AI prompt pazar yeri',
            'showNavigation' => true,
            'prevClass' => 'artist__prev',
            'nextClass' => 'artist__next',
            'viewAllUrl' => '/',
            'viewAllText' => 'Tümü'
        ])

        <div class="row pt-50">
            <div class="artist_slider__one">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        @forelse($latestArtists as $artist)
                            <div class="swiper-slide">
                                @include('partials.artist-card', ['artist' => $artist])
                            </div>
                        @empty
                            <div class="swiper-slide">
                                <p class="text-center">Henüz sanatçı bulunamadı</p>
                            </div>
                        @endforelse
                    </div>
                    <div class="swiper-button-prev artist__prev"></div>
                    <div class="swiper-button-next artist__next"></div>
                </div>
            </div>
        </div>

        @push('scripts')
            <script>
                new Swiper('.artist_slider__one .swiper', {
                    slidesPerView: 2,
                    spaceBetween: 30,
                    navigation: {
                        nextEl: '.artist_slider__one .swiper-button-next',
                        prevEl: '.artist_slider__one .swiper-button-prev',
                    },
                    breakpoints: {
                        320: {slidesPerView: 1},
                        768: {slidesPerView: 3},
                        1024: {slidesPerView: 6},
                    }
                });
            </script>
        @endpush
    </div>
</div>
