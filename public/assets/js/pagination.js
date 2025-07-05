// Sayfalama işlevselliği
document.addEventListener('DOMContentLoaded', function () {
    initializePagination();
});

function initializePagination() {
    const paginationLinks = document.querySelectorAll('.pagination a');

    paginationLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            // Eğer disabled ise tıklamayı engelle
            if (this.classList.contains('disabled') || this.getAttribute('aria-disabled') === 'true') {
                e.preventDefault();
                return;
            }

            // Loading state ekle
            this.classList.add('loading');
            this.innerHTML = '<i class="bi bi-arrow-clockwise spin"></i>';
        });
    });
}

// Sayfa yüklenirken loading animasyonu
function showPageLoading() {
    const container = document.querySelector('.row.gy-4');
    if (container) {
        container.style.opacity = '0.5';
        container.style.pointerEvents = 'none';
    }
}

function hidePageLoading() {
    const container = document.querySelector('.row.gy-4');
    if (container) {
        container.style.opacity = '1';
        container.style.pointerEvents = 'auto';
    }
}

// CSS animasyon için
const style = document.createElement('style');
style.textContent = `
    .spin {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .pagination .loading {
        pointer-events: none;
        opacity: 0.6;
    }
`;
document.head.appendChild(style);
