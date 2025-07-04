<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Prompt Dünyası')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/loader.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    @stack('head')
</head>

<body class="theme-dark-active">
    @include('partials.header')
    <!-- Hero Section -->
    <div class="hero_style__three section_gap_y_bottom__1 position-relative">
        <img src="{{ asset('assets/images/shapes/hero-shape-three.png') }}" alt="Hero Şekli"
            class="d-lg-block d-none hero_bg__shape blend-overlay position-absolute top-0 end-0 z-neg-1">
        <img src="{{ asset('assets/images/shapes/hero-star.svg') }}" alt="Yıldız Şekli"
            class="hero_star__shape position-absolute start-0 top-50">
        <div class="container">
            <div class="row align-items-center gy-4">
                <div class="col-lg-7">
                    <div class="hero__content">
                        <h1 class="text__outlined">AI PROMPT VİTRİNİ</h1>
                        <h1 class="text__gradient">YARATICI AI PROMPT'LARA HOŞ GELDİNİZ</h1>
                        <div class="hero__actions">
                            <a class="btn-rounded-v2" href="/collection">Promptları Keşfet</a>
                            <a class="btn-rounded-v3 varient-2" href="/create-single-nft">Yeni Prompt Oluştur</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-block text-lg-end">
                    <div class="hero__featured">
                        <img src="{{ asset('assets/images/hero/hero-three-feat.jpg') }}" alt="Öne Çıkan Görsel">
                        <img src="{{ asset('assets/images/hero/hero-batch.png') }}" alt="Batch Görseli" class="hero__batch">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Content -->
    <main class="theme-dark-active">
        <!--Fotograflı Kategoriler-->
        <div class="collection_style__three bg-body section_gap_y_bottom__1 position-relative z-1">
            <div class="container">
                <div class="row gy-4 align-items-end">
                    <div class="col-lg-6"><span class="sub-header-2">En Popüler</span>
                        <h2 class="section_title__2">Popüler Prompt Koleksiyonları</h2>
                    </div>
                    <div class="col-lg-6 d-flex justify-content-lg-end align-items-center">
                        <div class="slider__nav d-flex mr-3">
                            <div class="collection__three_prev navigation_btn_2 btn__prev mr-1"><i
                                    class="bi bi-chevron-left"></i></div>
                            <div class="collection__three_next navigation_btn_2 btn__next"><i
                                    class="bi bi-chevron-right"></i>
                            </div>
                        </div><a class="btn-rounded-v3" href="/">Tümü <!-- --><svg width="12" height="12"
                                viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1.25 6H11.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                                <path d="M6.25 1L11.25 6L6.25 11" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg></a>
                    </div>
                </div>




                <div class="collection_slider__two pt-40">
                    <div class="swiper swiper-initialized swiper-horizontal swiper-backface-hidden">
                        <div class="swiper-wrapper" id="swiper-wrapper-54d93ece103ad1015d" aria-live="polite">

                        </div>
                        <!-- Add Swiper navigation -->
                        <div class="swiper-button-prev swiper-button-disabled swiper-button-lock" tabindex="-1"
                            role="button" aria-label="Previous slide" aria-controls="swiper-wrapper-54d93ece103ad1015d"
                            aria-disabled="true">
                        </div>
                        <div class="swiper-button-next swiper-button-disabled swiper-button-lock" tabindex="-1"
                            role="button" aria-label="Next slide" aria-controls="swiper-wrapper-54d93ece103ad1015d"
                            aria-disabled="true"></div>
                        <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                        <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                    </div>
                </div>



                <!-- Initialize Swiper -->
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        var collectionSwiper = new Swiper('.collection_slider__two .swiper', {
                            slidesPerView: 4,
                            spaceBetween: 30,
                            navigation: {
                                nextEl: '.collection_slider__two .swiper-button-next',
                                prevEl: '.collection_slider__two .swiper-button-prev',
                            },
                            breakpoints: {
                                320: {
                                    slidesPerView: 1,
                                },
                                768: {
                                    slidesPerView: 2,
                                },
                                1024: {
                                    slidesPerView: 3,
                                },
                                1200: {
                                    slidesPerView: 4,
                                },
                            }
                        });
                    });
                </script>
            </div>
        </div>
        <!--Fotograflı Kategoriler-->

        <!--En Çok Beğenilenler-->
        <div class="seller_style__three bg-body section_gap_y_bottom__1">
            <div class="container">
                <div class="row justify-content-center pb-5">
                    <div class="col-lg-6 text-center">
                        <h2 class="section_title__2">En Çok Beğenilenler</h2>
                        <p class="disc-text pt-2">En popüler AI prompt pazar yeri</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 order-0">
                        <div class="row gy-xl-0 gy-3">
    {{-- Satıcılar Controller'dan $sellers olarak gönderildi varsayılıyor --}}
    @foreach($sellers as $seller)
        <div class="col-lg-3 col-md-6 col-sm-6">
            @include('partials.seller-card', ['seller' => $seller])
        </div>
    @endforeach
    {{-- Eğer component kullanmak isterseniz: --}}
    {{-- <x-seller-card :seller="$seller" /> --}}
</div>
<!-- Açıklama: Yukarıdaki kodda seller kartı için partial veya component kullanımı ile kod tekrarını önledik. $sellers dizisi controller'dan gelmeli. -->
                        </div>
                    </div>
                    <div class="col-lg-12 order-2 order-lg-1">
                        <div class="row pt-3 pt-xl-5 gy-xl-0 gy-3 justify-content-lg-center has_border__top">
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="seller_card_style__three">
                                    <div class="seller__thumb"><img src="{{ asset('assets/images/sellers/seller-five.png') }}" alt="Satıcı 5">
                                    </div>
                                    <div class="seller__disc">
                                        <h5 class="seller__name"><a href="/nft-detail">Millie_Yate</a></h5><span
                                            class="total__spend">$1,954</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="seller_card_style__three">
                                    <div class="seller__thumb"><img src="{{ asset('assets/images/sellers/seller-six.png') }}" alt="Satıcı 6">
                                    </div>
                                    <div class="seller__disc">
                                        <h5 class="seller__name"><a href="/nft-detail">Millie_Yate</a></h5><span
                                            class="total__spend">$1,954</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="seller_card_style__three">
                                    <div class="seller__thumb"><img src="{{ asset('assets/images/sellers/seller-seven.png') }}" alt="Satıcı 7">
                                    </div>
                                    <div class="seller__disc">
                                        <h5 class="seller__name"><a href="/nft-detail">Millie_Yate</a></h5><span
                                            class="total__spend">$1,954</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 order-1 order-lg-2">
                        <div class="row pt-3 gy-xl-0 pt-xl-5 gy-3 has_border__top">
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="seller_card_style__three">
                                    <div class="seller__thumb"><img src="{{ asset('assets/images/sellers/seller-five.png') }}" alt="Satıcı 5">
                                    </div>
                                    <div class="seller__disc">
                                        <h5 class="seller__name"><a href="/nft-detail">Millie_Yate</a></h5><span
                                            class="total__spend">$1,954</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="seller_card_style__three">
                                    <div class="seller__thumb"><img src="{{ asset('assets/images/sellers/seller-six.png') }}" alt="Satıcı 6">
                                    </div>
                                    <div class="seller__disc">
                                        <h5 class="seller__name"><a href="/nft-detail">Millie_Yate</a></h5><span
                                            class="total__spend">$1,954</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="seller_card_style__three">
                                    <div class="seller__thumb"><img src="{{ asset('assets/images/sellers/seller-seven.png') }}" alt="Satıcı 7">
                                    </div>
                                    <div class="seller__disc">
                                        <h5 class="seller__name"><a href="/nft-detail">Millie_Yate</a></h5><span
                                            class="total__spend">$1,954</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="seller_card_style__three">
                                    <div class="seller__thumb"><img src="{{ asset('assets/images/sellers/seller-eight.png') }}" alt="Satıcı 8">
                                    </div>
                                    <div class="seller__disc">
                                        <h5 class="seller__name"><a href="/nft-detail">Millie_Yate</a></h5><span
                                            class="total__spend">$1,954</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- En Çok Beğenilenler-->

        <!--Öne Çıkan Prompt'lar-->
        @include('partials.prompt-grid')
        <!--Öne Çıkan Prompt'lar-->

        <!--Yayıncılar-->
        <div class="artists_style__one bg-body section_gap_y_bottom__1">
            <div class="container">
                <div class="row gy-4 align-items-end">
                    <div class="col-lg-6">
                        <h2 class="section_title__2">Öne Çıkan Prompt Yazarları</h2>
                        <p class="disc-text pt-2">En popüler AI prompt pazar yeri</p>
                    </div>
                    <div class="col-lg-6 d-flex justify-content-lg-end align-items-center">
                        <div class="slider__nav d-flex mr-3">
                            <div class="artist__prev navigation_btn_2 btn__prev mr-1">
                                <i class="bi bi-chevron-left"></i>
                            </div>
                            <div class="artist__next navigation_btn_2 btn__next">
                                <i class="bi bi-chevron-right"></i>
                            </div>
                        </div>
                        <a class="btn-rounded-v3" href="/">
                            Tümü
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M1.25 6H11.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                                </path>
                                <path d="M6.25 1L11.25 6L6.25 11" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="row pt-50">
                    <div class="artist_slider__one">
    <div class="swiper swiper-initialized swiper-horizontal swiper-pointer-events">
        <div class="swiper-wrapper">
            {{-- Sanatçılar Controller'dan $artists olarak gönderildi varsayılıyor --}}
            @foreach($artists as $artist)
                <div class="swiper-slide" style="width: 212px; margin-right: 30px;">
                    @include('partials.artist-card', ['artist' => $artist])
                </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Açıklama: Sanatçı kartları da partial ile dinamikleştirildi. $artists dizisi controller'dan gelmeli. -->
                </div>
            </div>
        </div>
        <!--Yayıncılar-->


        <!--Topluluğa Katılın-->
        <div class="community_style_one section_gap_y_bottom__1 section_gap_y_top__1">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 text-center">
                        <h2 class="section_title__2">Topluluğa Katılın</h2>
                        <p class="disc-text pt-2">Prompt Dünyası topluluğuna katılın, diğer kullanıcılarla iletişime
                            geçin ve fikirlerinizi paylaşın.</p>
                        <ul class="community_social__links d-flex flex-wrap justify-content-center">
                            <li><a href="/"><i class="bi bi-twitter"></i></a></li>
                            <li><a href="/"><i class="bi bi-linkedin"></i></a></li>
                            <li><a href="/"><i class="bi bi-youtube"></i></a></li>
                            <li><a href="/"><i class="bi bi-github"></i></a></li>
                            <li><a href="/"><i class="bi bi-discord"></i></a></li>
                        </ul>
                    </div>
                </div>

                <!--Prompt Oluşturun-->
                <div class="row section_gap_y_top__1 nft_process__wrap justify-content-center gy-4">
                    <div class="col-lg-3 col-sm-6">
                        <div class="nft_process__card">
                            <div class="process__icon"><img src="{{ asset('assets/images/icons/process-doc.svg') }}" alt="Koleksiyon Oluştur">
                            </div>
                            <h5>Koleksiyon Oluşturun</h5>
                            <p>Yaratıcı AI prompt'larınızı düzenleyin ve kategorilere ayırın.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="nft_process__card">
                            <div class="process__icon"><img src="{{ asset('assets/images/icons/process-card.svg') }}" alt="Hesap Oluştur">
                            </div>
                            <h5>Hesabınızı Oluşturun</h5>
                            <p>Size özel bir yazar profili oluşturun ve başlayın.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="nft_process__card">
                            <div class="process__icon"><img src="{{ asset('assets/images/icons/process-sell.svg') }}" alt="Prompt Paylaş">
                            </div>
                            <h5>Prompt'larınızı Paylaşın</h5>
                            <p>Diğer kullanıcılarla paylaşın ve gelir elde edin.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="nft_process__card">
                            <div class="process__icon"><img src="{{ asset('assets/images/icons/process-add.svg') }}" alt="Yeni Prompt">
                            </div>
                            <h5>Yeni Prompt Oluşturun</h5>
                            <p>Kendi AI prompt'larınızı oluşturun ve paylaşın.</p>
                        </div>
                    </div>
                </div>
                <!--Prompt Oluşturun-->
            </div>
        </div>
        <!--Topluluğa Katılın-->

        <!--Bloglar-->
        <div class="blog_style__one bg-body section_gap_y_bottom__1">
            <div class="container">
                <div class="row gy-4 align-items-end">
                    <div class="col-md-7"><span class="sub-header-2">En Popüler</span>
                        <h2 class="section_title__2">Popüler Prompt Koleksiyonları</h2>
                    </div>
                    <div class="col-md-5 text-md-end"><a class="btn-rounded-v3">Tüm Yazıları Görüntüle</a></div>
                </div>
                <div class="row pt-50">
                    <div class="col-lg-12">
    {{-- Bloglar Controller'dan $blogs olarak gönderildi varsayılıyor --}}
    @foreach($blogs as $blog)
        @include('partials.blog-card', ['blog' => $blog])
    @endforeach
    <!-- Açıklama: Blog kartları da partial ile dinamikleştirildi. $blogs dizisi controller'dan gelmeli. -->
</div>
                    </div>
                </div>
            </div>
        </div>
        <!--Bloglar-->
    </main>
    @include('partials.footer')
</body>

</html>