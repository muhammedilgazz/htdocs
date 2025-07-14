// Preloader devre dışı bırakıldı
console.log('Preloader scripts devre dışı bırakıldı');

(function ($) {
    "use strict"

    //to keep the current page active
    $(function () {
        for (
            var lc = window.location,
            o = $(".settings-menu a, .menu a")
                .filter(function () {
                    return this.href == lc
                })
                .addClass("active")
                .parent()
                .addClass("active");
            ;

        ) {
            // console.log(o)
            if (!o.is("li")) break
            o = o.parent().addClass("show").parent().addClass("active")
        }
    })

    $('.content-body').css({ 'min-height': (($(window).height())) + 50 + 'px' })
})(jQuery);


// Dark light toggle switch
window.addEventListener('load', function () {
    let onpageLoad = localStorage.getItem("theme") || "light"; // Default to "light" if no theme is set
    let element = document.body;

    if (onpageLoad) {
        element.classList.add(onpageLoad);
    }

    let themeElement = document.getElementById("theme");
    if (themeElement) {
        themeElement.textContent = onpageLoad;
    }
});

function themeToggle() {
    let element = document.body;
    element.classList.toggle("dark-theme");

    let theme = localStorage.getItem("theme");

    if (theme && theme === "dark-theme") {
        localStorage.setItem("theme", "");
    } else {
        localStorage.setItem("theme", "dark-theme");
    }
}

// Mobile Sidebar Toggle
document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.querySelector('.sidebar');
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            sidebar.classList.toggle('show');
            console.log('Sidebar toggle clicked');
        });
        
        // Close sidebar when clicking outside
        document.addEventListener('click', function(e) {
            if (window.innerWidth <= 1024 && sidebar && sidebarToggle) {
                if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                    sidebar.classList.remove('show');
                }
            }
        });
    }
    
    // Close sidebar on window resize
    window.addEventListener('resize', function() {
        if (sidebar && window.innerWidth > 1024) {
            sidebar.classList.remove('show');
        }
    });
});

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]:not([data-bs-toggle])').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Material Design Ripple Effect
function createRipple(event) {
    const button = event.currentTarget;
    
    const circle = document.createElement('span');
    const diameter = Math.max(button.clientWidth, button.clientHeight);
    const radius = diameter / 2;
    
    const rect = button.getBoundingClientRect();
    circle.style.width = circle.style.height = `${diameter}px`;
    circle.style.left = `${event.clientX - rect.left - radius}px`;
    circle.style.top = `${event.clientY - rect.top - radius}px`;
    circle.classList.add('ripple-effect');
    
    const ripple = button.getElementsByClassName('ripple-effect')[0];
    if (ripple) {
        ripple.remove();
    }
    
    button.appendChild(circle);
}

// Add ripple effect to all ripple elements
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.ripple').forEach(button => {
        button.addEventListener('click', createRipple);
    });

    // Add loading states to buttons (only for demo buttons)
    document.querySelectorAll('.btn[data-loading]').forEach(button => {
        button.addEventListener('click', function() {
            if (!this.classList.contains('btn-loading')) {
                this.classList.add('btn-loading');
                this.innerHTML = '<span class="loading"></span> Yükleniyor...';
                
                // Remove loading state after 2 seconds (for demo)
                setTimeout(() => {
                    this.classList.remove('btn-loading');
                    this.innerHTML = this.getAttribute('data-original-text') || 'Tamamlandı';
                }, 2000);
            }
        });
        
        // Store original text
        button.setAttribute('data-original-text', button.innerHTML);
    });
});

// Material Design Snackbar
function showSnackbar(message, type = 'info') {
    const snackbar = document.createElement('div');
    snackbar.className = 'snackbar';
    snackbar.textContent = message;
    
    if (type === 'success') {
        snackbar.style.background = '#4caf50';
    } else if (type === 'error') {
        snackbar.style.background = '#f44336';
    } else if (type === 'warning') {
        snackbar.style.background = '#ff9800';
    }
    
    document.body.appendChild(snackbar);
    
    setTimeout(() => {
        snackbar.classList.add('show');
    }, 100);
    
    setTimeout(() => {
        snackbar.classList.remove('show');
        setTimeout(() => {
            document.body.removeChild(snackbar);
        }, 300);
    }, 3000);
}

// Global snackbar function
window.showSnackbar = showSnackbar;

// Alt Menü İşlevleri
document.addEventListener('DOMContentLoaded', function() {
    // Harcamalar alt menüsü için collapse işlevi
    const harcamalarToggle = document.querySelector('[data-bs-target="#harcamalarSubmenu"]');
    const harcamalarSubmenu = document.getElementById('harcamalarSubmenu');
    
    if (harcamalarToggle && harcamalarSubmenu) {
        // Sayfa yüklendiğinde aktif sayfa varsa menüyü aç
        const activeSubmenuItem = harcamalarSubmenu.querySelector('.nav-link.active');
        if (activeSubmenuItem) {
            harcamalarSubmenu.classList.add('show');
            harcamalarToggle.setAttribute('aria-expanded', 'true');
        }
        
        // Toggle işlevi
        harcamalarToggle.addEventListener('click', function(e) {
            e.preventDefault();
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            
            if (isExpanded) {
                harcamalarSubmenu.classList.remove('show');
                this.setAttribute('aria-expanded', 'false');
            } else {
                harcamalarSubmenu.classList.add('show');
                this.setAttribute('aria-expanded', 'true');
            }
        });
    }
    
    // Alt menü öğelerine tıklandığında mobilde sidebar'ı kapat
    const submenuItems = document.querySelectorAll('#harcamalarSubmenu .nav-link');
    submenuItems.forEach(item => {
        item.addEventListener('click', function() {
            if (window.innerWidth <= 1024) {
                const sidebar = document.querySelector('.sidebar');
                if (sidebar) {
                    sidebar.classList.remove('show');
                }
            }
        });
    });
});