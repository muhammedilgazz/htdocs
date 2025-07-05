// Navigasyon okları ve kategori filtreleme
document.addEventListener('DOMContentLoaded', function () {
    // Swiper navigasyon düzeltmesi
    initializeNavigationButtons();

    // Kategori filtreleme
    initializeCategoryFiltering();

    // Görünüm değiştirme (grid/list)
    initializeViewToggle();
});

function initializeNavigationButtons() {
    // Tüm navigasyon butonları
    const navButtons = document.querySelectorAll('.navigation_btn_2, .collection__three_prev, .collection__three_next');

    navButtons.forEach(button => {
        button.addEventListener('click', function () {
            const isNext = this.classList.contains('btn__next') || this.classList.contains('collection__three_next');
            const isPrev = this.classList.contains('btn__prev') || this.classList.contains('collection__three_prev');

            // Swiper instance'ını bul
            const swiperContainer = this.closest('.swiper') ||
                document.querySelector('.collection_slider__two .swiper') ||
                document.querySelector('.swiper');

            if (swiperContainer && swiperContainer.swiper) {
                if (isNext) {
                    swiperContainer.swiper.slideNext();
                } else if (isPrev) {
                    swiperContainer.swiper.slidePrev();
                }
            }
        });
    });
}

function initializeCategoryFiltering() {
    // Kategori tab butonları
    const categoryTabs = document.querySelectorAll('.nft_nav_pills__two .nav-link');

    categoryTabs.forEach(tab => {
        tab.addEventListener('click', function (e) {
            e.preventDefault();

            // Aktif sınıfı güncelle
            categoryTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            // Kategori ID'sini al
            const categoryId = this.id.replace('nft_pill_', '');

            // İçeriği filtrele
            filterPromptsByCategory(categoryId);
        });
    });
}

function filterPromptsByCategory(categoryId) {
    const promptCards = document.querySelectorAll('[data-category]');

    promptCards.forEach(card => {
        if (categoryId === 'all' || card.getAttribute('data-category') === categoryId) {
            card.style.display = 'block';
            card.classList.add('fade-in');
        } else {
            card.style.display = 'none';
            card.classList.remove('fade-in');
        }
    });
}

function initializeViewToggle() {
    const viewButtons = document.querySelectorAll('[data-view]');

    viewButtons.forEach(button => {
        button.addEventListener('click', function () {
            const view = this.getAttribute('data-view');

            // Aktif buton güncelle
            viewButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            // URL güncelle
            const url = new URL(window.location);
            url.searchParams.set('view', view);
            window.history.pushState({}, '', url);

            // Görünümü değiştir
            toggleView(view);
        });
    });
}

function toggleView(view) {
    const container = document.querySelector('.row.gy-4');
    if (!container) return;

    if (view === 'list') {
        container.classList.add('list-view');
        container.querySelectorAll('.col-lg-4').forEach(col => {
            col.className = 'col-12';
        });
    } else {
        container.classList.remove('list-view');
        container.querySelectorAll('.col-12').forEach(col => {
            col.className = 'col-lg-4 col-md-6';
        });
    }
}
