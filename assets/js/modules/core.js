/**
 * Ekash Core Module - Temel fonksiyonlar ve yardımcı işlevler
 * @version 1.0.0
 */

const EkashCore = (function() {
    'use strict';

    // Private variables
    let isInitialized = false;
    const config = {
        theme: {
            default: 'light',
            storageKey: 'theme'
        },
        animation: {
            duration: 300,
            easing: 'ease-in-out'
        }
    };

    /**
     * Initialize core functionality
     */
    function init() {
        if (isInitialized) {
            console.warn('EkashCore already initialized');
            return;
        }

        console.log('🚀 Ekash Core initializing...');
        
        // Initialize theme system
        initTheme();
        
        // Initialize global event listeners
        initGlobalEvents();
        
        // Set content body min height
        setContentMinHeight();
        
        isInitialized = true;
        console.log('✅ Ekash Core initialized successfully');
    }

    /**
     * Theme management system
     */
    function initTheme() {
        const savedTheme = getStoredTheme();
        const bodyElement = document.body;
        
        if (savedTheme) {
            bodyElement.classList.add(savedTheme);
        }
        
        updateThemeIndicator(savedTheme || config.theme.default);
    }

    /**
     * Get theme from localStorage
     */
    function getStoredTheme() {
        return localStorage.getItem(config.theme.storageKey) || config.theme.default;
    }

    /**
     * Save theme to localStorage
     */
    function saveTheme(theme) {
        localStorage.setItem(config.theme.storageKey, theme);
    }

    /**
     * Toggle between light and dark theme
     */
    function toggleTheme() {
        const bodyElement = document.body;
        const currentTheme = getStoredTheme();
        
        bodyElement.classList.toggle('dark-theme');
        
        const newTheme = currentTheme === 'dark-theme' ? 'light' : 'dark-theme';
        saveTheme(newTheme);
        updateThemeIndicator(newTheme);
        
        // Trigger theme change event
        triggerEvent('themeChanged', { theme: newTheme });
    }

    /**
     * Update theme indicator in UI
     */
    function updateThemeIndicator(theme) {
        const themeElement = document.getElementById('theme');
        if (themeElement) {
            themeElement.textContent = theme;
        }
    }

    /**
     * Set content body minimum height
     */
    function setContentMinHeight() {
        const contentBody = document.querySelector('.content-body');
        if (contentBody) {
            const minHeight = window.innerHeight + 50;
            contentBody.style.minHeight = `${minHeight}px`;
        }
    }

    /**
     * Initialize global event listeners
     */
    function initGlobalEvents() {
        // Window resize handler
        window.addEventListener('resize', debounce(() => {
            setContentMinHeight();
            triggerEvent('windowResized', { 
                width: window.innerWidth, 
                height: window.innerHeight 
            });
        }, 250));

        // Page visibility change
        document.addEventListener('visibilitychange', () => {
            triggerEvent('visibilityChanged', { 
                hidden: document.hidden 
            });
        });
    }

    /**
     * Utility function to debounce function calls
     */
    function debounce(func, wait) {
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

    /**
     * Utility function to throttle function calls
     */
    function throttle(func, limit) {
        let inThrottle;
        return function executedFunction(...args) {
            if (!inThrottle) {
                func.apply(this, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }

    /**
     * Custom event system
     */
    function triggerEvent(eventName, data = {}) {
        const event = new CustomEvent(`ekash:${eventName}`, {
            detail: data,
            bubbles: true,
            cancelable: true
        });
        document.dispatchEvent(event);
    }

    /**
     * Add event listener for custom events
     */
    function on(eventName, callback) {
        document.addEventListener(`ekash:${eventName}`, callback);
    }

    /**
     * Remove event listener for custom events
     */
    function off(eventName, callback) {
        document.removeEventListener(`ekash:${eventName}`, callback);
    }

    /**
     * Wait for DOM to be ready
     */
    function ready(callback) {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', callback);
        } else {
            callback();
        }
    }

    /**
     * Create element with attributes and content
     */
    function createElement(tag, attributes = {}, content = '') {
        const element = document.createElement(tag);
        
        // Set attributes
        Object.entries(attributes).forEach(([key, value]) => {
            if (key === 'className') {
                element.className = value;
            } else if (key === 'innerHTML') {
                element.innerHTML = value;
            } else {
                element.setAttribute(key, value);
            }
        });
        
        // Set content
        if (content) {
            element.textContent = content;
        }
        
        return element;
    }

    /**
     * Check if device is mobile
     */
    function isMobile() {
        return window.innerWidth <= 768;
    }

    /**
     * Check if device is tablet
     */
    function isTablet() {
        return window.innerWidth > 768 && window.innerWidth <= 1024;
    }

    /**
     * Check if device is desktop
     */
    function isDesktop() {
        return window.innerWidth > 1024;
    }

    /**
     * Format currency
     */
    function formatCurrency(amount, currency = 'TRY') {
        return new Intl.NumberFormat('tr-TR', {
            style: 'currency',
            currency: currency,
            minimumFractionDigits: 2
        }).format(amount);
    }

    /**
     * Format date
     */
    function formatDate(date, format = 'tr-TR') {
        return new Intl.DateTimeFormat(format).format(new Date(date));
    }

    /**
     * Validate email
     */
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    /**
     * Generate random ID
     */
    function generateId(length = 8) {
        return Math.random().toString(36).substring(2, 2 + length);
    }

    /**
     * Deep clone object
     */
    function deepClone(obj) {
        return JSON.parse(JSON.stringify(obj));
    }

    /**
     * Check if object is empty
     */
    function isEmpty(obj) {
        return obj && Object.keys(obj).length === 0 && obj.constructor === Object;
    }

    /**
     * Public API
     */
    return {
        // Initialization
        init,
        
        // Theme management
        toggleTheme,
        getStoredTheme,
        
        // Event system
        on,
        off,
        triggerEvent,
        
        // DOM utilities
        ready,
        createElement,
        
        // Device detection
        isMobile,
        isTablet,
        isDesktop,
        
        // Formatting utilities
        formatCurrency,
        formatDate,
        
        // Validation utilities
        isValidEmail,
        
        // General utilities
        debounce,
        throttle,
        generateId,
        deepClone,
        isEmpty,
        
        // Config access
        config
    };
})();

// Auto-initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    EkashCore.init();
});

// Make theme toggle globally available
window.themeToggle = () => EkashCore.toggleTheme();

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = EkashCore;
}

// Global namespace
window.EkashCore = EkashCore;