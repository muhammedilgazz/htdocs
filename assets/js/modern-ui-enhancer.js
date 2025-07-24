/**
 * Modern UI Enhancement System
 * Advanced JavaScript for enhanced user experience
 */

class ModernUIEnhancer {
    constructor() {
        this.theme = localStorage.getItem('theme') || 'light';
        this.isInitialized = false;
        this.animations = new Map();
        this.observers = new Map();
        this.init();
    }

    init() {
        if (this.isInitialized) return;
        
        this.setTheme(this.theme);
        this.initializeComponents();
        this.setupEventListeners();
        this.initializeAnimations();
        this.setupObservers();
        
        this.isInitialized = true;
    }

    // ====== THEME MANAGEMENT ======
    setTheme(theme) {
        this.theme = theme;
        document.documentElement.setAttribute('data-theme', theme);
        localStorage.setItem('theme', theme);
        
        // Update theme toggle if exists
        const themeToggle = document.querySelector('.theme-toggle');
        if (themeToggle) {
            themeToggle.classList.toggle('dark', theme === 'dark');
        }
        
        // Dispatch theme change event
        window.dispatchEvent(new CustomEvent('themeChange', { detail: { theme } }));
    }

    toggleTheme() {
        const newTheme = this.theme === 'light' ? 'dark' : 'light';
        this.setTheme(newTheme);
        
        // Add transition effect
        document.body.style.transition = 'all 0.3s ease';
        setTimeout(() => {
            document.body.style.transition = '';
        }, 300);
    }

    // ====== COMPONENT INITIALIZATION ======
    initializeComponents() {
        this.initializeCards();
        this.initializeButtons();
        this.initializeForms();
        this.initializeModals();
        this.initializeDropdowns();
        this.initializeToasts();
        this.initializeTabs();
    }

    initializeCards() {
        document.querySelectorAll('.card-modern, .stat-card-modern').forEach(card => {
            this.addHoverEffect(card);
            this.addClickRipple(card);
        });
    }

    initializeButtons() {
        document.querySelectorAll('.btn-modern, .btn-enhanced').forEach(button => {
            this.addButtonEnhancements(button);
        });
    }

    initializeForms() {
        // Floating labels
        document.querySelectorAll('.form-floating-modern').forEach(container => {
            const input = container.querySelector('.form-input-floating');
            const label = container.querySelector('.form-label-floating');
            
            if (input && label) {
                this.setupFloatingLabel(input, label);
            }
        });

        // Custom selects
        document.querySelectorAll('.select-modern').forEach(select => {
            this.initializeCustomSelect(select);
        });
    }

    initializeModals() {
        document.querySelectorAll('.modal-modern').forEach(modal => {
            this.setupModal(modal);
        });
    }

    initializeDropdowns() {
        document.querySelectorAll('.dropdown-enhanced').forEach(dropdown => {
            this.setupDropdown(dropdown);
        });
    }

    initializeToasts() {
        this.createToastContainer();
    }

    initializeTabs() {
        document.querySelectorAll('.tabs-modern').forEach(tabContainer => {
            this.setupTabs(tabContainer);
        });
    }

    // ====== ANIMATION SYSTEM ======
    initializeAnimations() {
        // Intersection Observer for scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    this.animateElement(entry.target);
                }
            });
        }, observerOptions);

        // Observe all animatable elements
        document.querySelectorAll('[data-animate]').forEach(el => {
            observer.observe(el);
        });

        this.observers.set('scroll', observer);
    }

    animateElement(element) {
        const animationType = element.dataset.animate;
        const delay = element.dataset.delay || 0;
        
        setTimeout(() => {
            switch (animationType) {
                case 'fade-in':
                    element.classList.add('animate-fade-in');
                    break;
                case 'fade-in-up':
                    element.classList.add('animate-fade-in-up');
                    break;
                case 'slide-in-right':
                    element.classList.add('animate-slide-in-right');
                    break;
                case 'scale-in':
                    element.classList.add('animate-scale-in');
                    break;
                default:
                    element.classList.add('animate-fade-in');
            }
        }, delay);
    }

    // ====== INTERACTION ENHANCEMENTS ======
    addHoverEffect(element) {
        element.addEventListener('mouseenter', () => {
            element.style.transform = 'translateY(-4px)';
            element.style.boxShadow = 'var(--shadow-xl)';
        });

        element.addEventListener('mouseleave', () => {
            element.style.transform = '';
            element.style.boxShadow = '';
        });
    }

    addClickRipple(element) {
        element.addEventListener('click', (e) => {
            const rect = element.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            const ripple = document.createElement('div');
            ripple.style.cssText = `
                position: absolute;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                background: rgba(255, 255, 255, 0.3);
                border-radius: 50%;
                transform: scale(0);
                animation: ripple 0.6s ease-out;
                pointer-events: none;
                z-index: 1;
            `;
            
            element.style.position = 'relative';
            element.style.overflow = 'hidden';
            element.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    }

    addButtonEnhancements(button) {
        // Loading state
        const originalText = button.textContent;
        
        button.setLoading = (loading = true) => {
            if (loading) {
                button.disabled = true;
                button.innerHTML = `
                    <div class="loading-spinner-modern"></div>
                    <span>Yükleniyor...</span>
                `;
            } else {
                button.disabled = false;
                button.textContent = originalText;
            }
        };

        // Add ripple effect
        this.addClickRipple(button);
    }

    // ====== FORM ENHANCEMENTS ======
    setupFloatingLabel(input, label) {
        const updateLabel = () => {
            if (input.value || input === document.activeElement) {
                label.classList.add('active');
            } else {
                label.classList.remove('active');
            }
        };

        input.addEventListener('focus', updateLabel);
        input.addEventListener('blur', updateLabel);
        input.addEventListener('input', updateLabel);
        
        // Initial state
        updateLabel();
    }

    initializeCustomSelect(selectElement) {
        const trigger = selectElement.querySelector('.select-modern-trigger');
        const dropdown = selectElement.querySelector('.select-modern-dropdown');
        const options = selectElement.querySelectorAll('.select-modern-option');
        
        if (!trigger || !dropdown) return;

        trigger.addEventListener('click', () => {
            selectElement.classList.toggle('open');
        });

        options.forEach(option => {
            option.addEventListener('click', () => {
                const value = option.dataset.value;
                const text = option.textContent;
                
                // Update trigger text
                trigger.querySelector('span').textContent = text;
                
                // Update selected state
                options.forEach(opt => opt.classList.remove('selected'));
                option.classList.add('selected');
                
                // Close dropdown
                selectElement.classList.remove('open');
                
                // Dispatch change event
                selectElement.dispatchEvent(new CustomEvent('change', {
                    detail: { value, text }
                }));
            });
        });

        // Close on outside click
        document.addEventListener('click', (e) => {
            if (!selectElement.contains(e.target)) {
                selectElement.classList.remove('open');
            }
        });
    }

    // ====== MODAL SYSTEM ======
    setupModal(modal) {
        const closeBtn = modal.querySelector('.modal-modern-close');
        const backdrop = modal;
        
        // Open modal method
        modal.open = () => {
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
            
            // Focus trap
            const focusableElements = modal.querySelectorAll(
                'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
            );
            if (focusableElements.length > 0) {
                focusableElements[0].focus();
            }
        };

        // Close modal method
        modal.close = () => {
            modal.classList.remove('show');
            document.body.style.overflow = '';
        };

        // Event listeners
        if (closeBtn) {
            closeBtn.addEventListener('click', modal.close);
        }

        backdrop.addEventListener('click', (e) => {
            if (e.target === backdrop) {
                modal.close();
            }
        });

        // Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal.classList.contains('show')) {
                modal.close();
            }
        });
    }

    // ====== TOAST SYSTEM ======
    createToastContainer() {
        if (document.querySelector('.toast-container')) return;
        
        const container = document.createElement('div');
        container.className = 'toast-container';
        document.body.appendChild(container);
    }

    showToast({ type = 'info', title, message, duration = 5000, action = null }) {
        const container = document.querySelector('.toast-container');
        if (!container) return;

        const toast = document.createElement('div');
        toast.className = `toast-modern ${type}`;
        
        const icons = {
            success: 'check',
            error: 'close',
            warning: 'warning',
            info: 'info'
        };

        toast.innerHTML = `
            <div class="toast-icon">
                <i class="material-icons-round">${icons[type] || 'info'}</i>
            </div>
            <div class="toast-content">
                ${title ? `<div class="toast-title">${title}</div>` : ''}
                <div class="toast-message">${message}</div>
            </div>
            <button class="toast-close">
                <i class="material-icons-round">close</i>
            </button>
        `;

        container.appendChild(toast);

        // Show animation
        setTimeout(() => toast.classList.add('show'), 100);

        // Auto dismiss
        const dismissTimer = setTimeout(() => this.dismissToast(toast), duration);

        // Manual dismiss
        const closeBtn = toast.querySelector('.toast-close');
        closeBtn.addEventListener('click', () => {
            clearTimeout(dismissTimer);
            this.dismissToast(toast);
        });

        // Action button
        if (action) {
            const actionBtn = document.createElement('button');
            actionBtn.className = 'toast-action';
            actionBtn.textContent = action.text;
            actionBtn.addEventListener('click', () => {
                action.handler();
                this.dismissToast(toast);
            });
            toast.querySelector('.toast-content').appendChild(actionBtn);
        }

        return toast;
    }

    dismissToast(toast) {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }

    // ====== TAB SYSTEM ======
    setupTabs(tabContainer) {
        const tabs = tabContainer.querySelectorAll('.tab-modern');
        const panels = document.querySelectorAll('.tab-panel');
        
        tabs.forEach((tab, index) => {
            tab.addEventListener('click', () => {
                // Update tab states
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                
                // Update panel states
                panels.forEach(panel => panel.classList.remove('active'));
                if (panels[index]) {
                    panels[index].classList.add('active');
                }
                
                // Dispatch tab change event
                tabContainer.dispatchEvent(new CustomEvent('tabChange', {
                    detail: { activeIndex: index, activeTab: tab }
                }));
            });
        });
    }

    // ====== UTILITY METHODS ======
    setupEventListeners() {
        // Theme toggle
        document.addEventListener('click', (e) => {
            if (e.target.matches('.theme-toggle') || e.target.closest('.theme-toggle')) {
                this.toggleTheme();
            }
        });

        // Global keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            // Ctrl/Cmd + K for search
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                this.openSearch();
            }
            
            // Ctrl/Cmd + / for shortcuts help
            if ((e.ctrlKey || e.metaKey) && e.key === '/') {
                e.preventDefault();
                this.showShortcuts();
            }
        });

        // Performance monitoring
        if ('PerformanceObserver' in window) {
            this.setupPerformanceMonitoring();
        }
    }

    openSearch() {
        const searchModal = document.querySelector('#searchModal');
        if (searchModal && searchModal.open) {
            searchModal.open();
        }
    }

    showShortcuts() {
        this.showToast({
            type: 'info',
            title: 'Klavye Kısayolları',
            message: 'Ctrl+K: Arama, Ctrl+/: Kısayollar, Esc: Modalı Kapat',
            duration: 8000
        });
    }

    setupPerformanceMonitoring() {
        // Monitor Long Tasks
        new PerformanceObserver((list) => {
            list.getEntries().forEach((entry) => {
                if (entry.duration > 50) {
                    console.warn('Long task detected:', entry.duration + 'ms');
                }
            });
        }).observe({ entryTypes: ['longtask'] });

        // Monitor Layout Shifts
        new PerformanceObserver((list) => {
            let clsValue = 0;
            list.getEntries().forEach((entry) => {
                if (!entry.hadRecentInput) {
                    clsValue += entry.value;
                }
            });
            if (clsValue > 0.1) {
                console.warn('Layout shift detected:', clsValue);
            }
        }).observe({ entryTypes: ['layout-shift'] });
    }

    setupObservers() {
        // Resize Observer for responsive components
        const resizeObserver = new ResizeObserver((entries) => {
            entries.forEach((entry) => {
                const element = entry.target;
                const { width } = entry.contentRect;
                
                // Add responsive classes
                element.classList.toggle('is-small', width < 300);
                element.classList.toggle('is-medium', width >= 300 && width < 600);
                element.classList.toggle('is-large', width >= 600);
            });
        });

        // Observe cards and containers
        document.querySelectorAll('.card-modern, .container-modern').forEach(el => {
            resizeObserver.observe(el);
        });

        this.observers.set('resize', resizeObserver);
    }

    // ====== PUBLIC API ======
    addLoadingState(element, loading = true) {
        if (loading) {
            element.classList.add('loading');
            element.disabled = true;
        } else {
            element.classList.remove('loading');
            element.disabled = false;
        }
    }

    createSkeletonLoader(targetElement, type = 'card') {
        const skeleton = document.createElement('div');
        skeleton.className = `skeleton-modern skeleton-${type}`;
        
        if (type === 'text') {
            skeleton.innerHTML = `
                <div class="skeleton-title"></div>
                <div class="skeleton-paragraph"></div>
                <div class="skeleton-paragraph"></div>
                <div class="skeleton-paragraph"></div>
            `;
        }
        
        targetElement.appendChild(skeleton);
        return skeleton;
    }

    removeSkeletonLoader(skeleton) {
        if (skeleton && skeleton.parentNode) {
            skeleton.remove();
        }
    }

    // ====== ACCESSIBILITY ENHANCEMENTS ======
    enhanceAccessibility() {
        // Add focus visible for keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Tab') {
                document.body.classList.add('keyboard-navigation');
            }
        });

        document.addEventListener('mousedown', () => {
            document.body.classList.remove('keyboard-navigation');
        });

        // Add ARIA labels where missing
        document.querySelectorAll('button:not([aria-label]):not([aria-labelledby])').forEach(btn => {
            if (!btn.textContent.trim()) {
                btn.setAttribute('aria-label', 'Button');
            }
        });

        // Enhance form accessibility
        document.querySelectorAll('input:not([aria-label]):not([aria-labelledby])').forEach(input => {
            const label = document.querySelector(`label[for="${input.id}"]`);
            if (!label && input.placeholder) {
                input.setAttribute('aria-label', input.placeholder);
            }
        });
    }

    // ====== CLEANUP ======
    destroy() {
        // Remove all observers
        this.observers.forEach(observer => observer.disconnect());
        this.observers.clear();
        
        // Clear animations
        this.animations.clear();
        
        this.isInitialized = false;
    }
}

// ====== GLOBAL UTILITIES ======
class ModernUtils {
    static debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    static throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }

    static animate(element, keyframes, options = {}) {
        return element.animate(keyframes, {
            duration: 300,
            easing: 'ease-out',
            fill: 'forwards',
            ...options
        });
    }

    static formatCurrency(amount, currency = 'TRY') {
        return new Intl.NumberFormat('tr-TR', {
            style: 'currency',
            currency: currency
        }).format(amount);
    }

    static formatDate(date, options = {}) {
        return new Intl.DateTimeFormat('tr-TR', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            ...options
        }).format(new Date(date));
    }

    static copyToClipboard(text) {
        return navigator.clipboard.writeText(text);
    }

    static downloadFile(blob, filename) {
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = filename;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    }
}

// ====== INITIALIZATION ======
let modernUI;

document.addEventListener('DOMContentLoaded', () => {
    modernUI = new ModernUIEnhancer();
    
    // Make utilities globally available
    window.ModernUtils = ModernUtils;
    window.modernUI = modernUI;
    
    // Enhanced accessibility
    modernUI.enhanceAccessibility();
});

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { ModernUIEnhancer, ModernUtils };
}