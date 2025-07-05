document.addEventListener('DOMContentLoaded', function () {
    new Swiper('.collection_slider__two .swiper', {
        slidesPerView: 4,
        spaceBetween: 30,
        navigation: {
            nextEl: '.collection_slider__two .swiper-button-next',
            prevEl: '.collection_slider__two .swiper-button-prev',
        },
        breakpoints: {
            320: {slidesPerView: 1},
            768: {slidesPerView: 2},
            1024: {slidesPerView: 3},
            1200: {slidesPerView: 4},
        }
    });
});
