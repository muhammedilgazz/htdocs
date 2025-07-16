/**
 * Ekash Core Module - Enhanced Modern Version
 * @version 3.0.0
 * @description Core utilities, theme management, and event handling
 */

(function() {
    'use strict';

    // Core configuration
    const config = {
        debug: true,
        version: '3.0.0',
        theme: {
            default: 'light',
            storageKey: 'ekash-theme'
        },
        animations: {
            duration: 300,
            easing: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)'
        },
        breakpoints: {
            xs: 576,
            sm: 768,
            md: 992,
            lg: 1200,
            xl: 1400
        }
    };

    // Event system
    const events = {};
    const eventListeners = new Map();

    // Performance monitoring
    const performance = {
        marks: new Map(),
        measures: new Map()
    };

    // Theme system
    const theme = {
        current: localStorage.getItem(config.theme.storageKey) || config.theme.default,
        observers: new Set()
    };

    // Utility functions
    const utils = {
        // Enhanced debounce with immediate option
        debounce: function(func, wait, immediate = false) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    timeout = null;
                    if (!immediate) func(...args);
                };
                const callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func(...args);
            };
        },

        // Enhanced throttle
        throttle: function(func, limit) {
            let inThrottle;
            return function(...args) {
                if (!inThrottle) {
                    func.apply(this, args);
                    inThrottle = true;
                    setTimeout(() => inThrottle = false, limit);
                }
            };
        },

        // Deep merge objects
        deepMerge: function(target, ...sources) {
            if (!sources.length) return target;
            const source = sources.shift();

            if (this.isObject(target) && this.isObject(source)) {
                for (const key in source) {
                    if (this.isObject(source[key])) {
                        if (!target[key]) Object.assign(target, { [key]: {} });
                        this.deepMerge(target[key], source[key]);
                    } else {
                        Object.assign(target, { [key]: source[key] });
                    }
                }
            }

            return this.deepMerge(target, ...sources);
        },

        // Check if value is object
        isObject: function(item) {
            return item && typeof item === 'object' && !Array.isArray(item);
        },

        // Enhanced currency formatting
        formatCurrency: function(amount, currency = 'TRY') {
            const formatter = new Intl.NumberFormat('tr-TR', {
                style: 'currency',
                currency: currency,
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            return formatter.format(amount);
        },

        // Enhanced date formatting
        formatDate: function(date, options = {}) {
            const defaultOptions = {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            const formatter = new Intl.DateTimeFormat('tr-TR', { ...defaultOptions, ...options });
            return formatter.format(new Date(date));
        },

        // Relative time formatting
        formatRelativeTime: function(date) {
            const now = new Date();
            const diff = now - new Date(date);
            const seconds = Math.floor(diff / 1000);
            const minutes = Math.floor(seconds / 60);
            const hours = Math.floor(minutes / 60);
            const days = Math.floor(hours / 24);

            if (days > 0) return `${days} gün önce`;
            if (hours > 0) return `${hours} saat önce`;
            if (minutes > 0) return `${minutes} dakika önce`;
            return 'Az önce';
        },

        // Generate UUID
        generateUUID: function() {
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                const r = Math.random() * 16 | 0;
                const v = c === 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
        },

        // Enhanced element selector
        $: function(selector, context = document) {
            return context.querySelector(selector);
        },

        // Enhanced element selector (all)
        $$: function(selector, context = document) {
            return Array.from(context.querySelectorAll(selector));
        },

        // Check if element is in viewport
        isInViewport: function(element) {
            const rect = element.getBoundingClientRect();
            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
            );
        },

        // Get device info
        getDeviceInfo: function() {
            return {
                width: window.innerWidth,
                height: window.innerHeight,
                isMobile: window.innerWidth < config.breakpoints.md,
                isTablet: window.innerWidth >= config.breakpoints.md && window.innerWidth < config.breakpoints.lg,
                isDesktop: window.innerWidth >= config.breakpoints.lg,
                userAgent: navigator.userAgent,
                platform: navigator.platform
            };
        },

        // Storage utilities
        storage: {
            set: function(key, value, expiry = null) {
                const item = {
                    value: value,
                    expiry: expiry ? Date.now() + expiry : null
                };
                localStorage.setItem(key, JSON.stringify(item));
            },

            get: function(key) {
                const item = localStorage.getItem(key);
                if (!item) return null;

                try {
                    const parsed = JSON.parse(item);
                    if (parsed.expiry && Date.now() > parsed.expiry) {
                        localStorage.removeItem(key);
                        return null;
                    }
                    return parsed.value;
                } catch (e) {
                    return null;
                }
            },

            remove: function(key) {
                localStorage.removeItem(key);
            },

            clear: function() {
                localStorage.clear();
            }
        }
    };

    // Enhanced event system
    const eventSystem = {
        // Subscribe to event
        on: function(event, callback, options = {}) {
            if (!events[event]) events[event] = [];
            
            const listener = {
                callback: callback,
                once: options.once || false,
                id: utils.generateUUID()
            };
            
            events[event].push(listener);
            
            // Store reference for cleanup
            if (!eventListeners.has(event)) {
                eventListeners.set(event, new Set());
            }
            eventListeners.get(event).add(listener);
            
            return listener.id;
        },

        // Unsubscribe from event
        off: function(event, id) {
            if (!events[event]) return;
            
            events[event] = events[event].filter(listener => listener.id !== id);
            
            if (eventListeners.has(event)) {
                const listeners = eventListeners.get(event);
                listeners.forEach(listener => {
                    if (listener.id === id) {
                        listeners.delete(listener);
                    }
                });
            }
        },

        // Trigger event
        trigger: function(event, data = {}) {
            if (!events[event]) return;
            
            const eventData = {
                type: event,
                data: data,
                timestamp: Date.now()
            };
            
            events[event].forEach(listener => {
                try {
                    listener.callback(eventData);
                    
                    // Remove once listeners
                    if (listener.once) {
                        this.off(event, listener.id);
                    }
                } catch (error) {
                    console.error(`Error in event listener for ${event}:`, error);
                }
            });
        },

        // Clear all listeners for event
        clear: function(event) {
            if (events[event]) {
                delete events[event];
                eventListeners.delete(event);
            }
        }
    };

    // Enhanced theme system
    const themeSystem = {
        // Get current theme
        get: function() {
            return theme.current;
        },

        // Set theme
        set: function(newTheme) {
            if (newTheme === theme.current) return;
            
            const oldTheme = theme.current;
            theme.current = newTheme;
            
            // Update DOM
            document.documentElement.setAttribute('data-bs-theme', newTheme);
            
            // Save to storage
            utils.storage.set(config.theme.storageKey, newTheme);
            
            // Notify observers
            theme.observers.forEach(observer => {
                try {
                    observer({ oldTheme, newTheme });
                } catch (error) {
                    console.error('Error in theme observer:', error);
                }
            });
            
            // Trigger event
            eventSystem.trigger('themeChanged', { oldTheme, newTheme });
        },

        // Toggle theme
        toggle: function() {
            const newTheme = theme.current === 'light' ? 'dark' : 'light';
            this.set(newTheme);
        },

        // Add theme observer
        observe: function(callback) {
            theme.observers.add(callback);
            return () => theme.observers.delete(callback);
        }
    };

    // Enhanced performance monitoring
    const performanceMonitor = {
        // Mark performance point
        mark: function(name) {
            const mark = {
                name: name,
                time: Date.now(),
                memory: performance.memory ? performance.memory.usedJSHeapSize : null
            };
            performance.marks.set(name, mark);
            
            if (config.debug) {
                console.log(`⏱️ Performance mark: ${name}`, mark);
            }
        },

        // Measure performance between marks
        measure: function(name, startMark, endMark) {
            const start = performance.marks.get(startMark);
            const end = performance.marks.get(endMark);
            
            if (!start || !end) {
                console.warn(`Cannot measure ${name}: missing marks`);
                return null;
            }
            
            const measure = {
                name: name,
                duration: end.time - start.time,
                memoryDiff: end.memory && start.memory ? end.memory - start.memory : null
            };
            
            performance.measures.set(name, measure);
            
            if (config.debug) {
                console.log(`📊 Performance measure: ${name}`, measure);
            }
            
            return measure;
        },

        // Get all performance data
        getAll: function() {
            return {
                marks: Array.from(performance.marks.entries()),
                measures: Array.from(performance.measures.entries())
            };
        },

        // Clear performance data
        clear: function() {
            performance.marks.clear();
            performance.measures.clear();
        }
    };

    // Enhanced animation system
    const animationSystem = {
        // Animate element
        animate: function(element, keyframes, options = {}) {
            const defaultOptions = {
                duration: config.animations.duration,
                easing: config.animations.easing,
                fill: 'both'
            };
            
            const animation = element.animate(keyframes, { ...defaultOptions, ...options });
            
            return new Promise((resolve, reject) => {
                animation.addEventListener('finish', () => resolve(animation));
                animation.addEventListener('cancel', () => reject(new Error('Animation cancelled')));
            });
        },

        // Fade in element
        fadeIn: function(element, options = {}) {
            return this.animate(element, [
                { opacity: 0 },
                { opacity: 1 }
            ], options);
        },

        // Fade out element
        fadeOut: function(element, options = {}) {
            return this.animate(element, [
                { opacity: 1 },
                { opacity: 0 }
            ], options);
        },

        // Slide in element
        slideIn: function(element, direction = 'up', options = {}) {
            const transforms = {
                up: [{ transform: 'translateY(30px)' }, { transform: 'translateY(0)' }],
                down: [{ transform: 'translateY(-30px)' }, { transform: 'translateY(0)' }],
                left: [{ transform: 'translateX(-30px)' }, { transform: 'translateX(0)' }],
                right: [{ transform: 'translateX(30px)' }, { transform: 'translateX(0)' }]
            };
            
            return this.animate(element, [
                { opacity: 0, ...transforms[direction][0] },
                { opacity: 1, ...transforms[direction][1] }
            ], options);
        },

        // Scale element
        scale: function(element, from = 0.9, to = 1, options = {}) {
            return this.animate(element, [
                { transform: `scale(${from})`, opacity: 0 },
                { transform: `scale(${to})`, opacity: 1 }
            ], options);
        }
    };

    // Enhanced error handling
    const errorHandler = {
        // Handle error
        handle: function(error, context = 'Unknown') {
            const errorInfo = {
                message: error.message,
                stack: error.stack,
                context: context,
                timestamp: Date.now(),
                url: window.location.href,
                userAgent: navigator.userAgent
            };
            
            // Log to console
            console.error(`[${context}] Error:`, errorInfo);
            
            // Trigger error event
            eventSystem.trigger('error', errorInfo);
            
            // Store in session storage for debugging
            if (config.debug) {
                const errors = JSON.parse(sessionStorage.getItem('ekash-errors') || '[]');
                errors.push(errorInfo);
                sessionStorage.setItem('ekash-errors', JSON.stringify(errors.slice(-10))); // Keep last 10
            }
        },

        // Get stored errors
        getErrors: function() {
            return JSON.parse(sessionStorage.getItem('ekash-errors') || '[]');
        },

        // Clear stored errors
        clearErrors: function() {
            sessionStorage.removeItem('ekash-errors');
        }
    };

    // Initialize core
    function init() {
        performanceMonitor.mark('core-init-start');
        
        // Set initial theme
        document.documentElement.setAttribute('data-bs-theme', theme.current);
        
        // Setup global error handling
        window.addEventListener('error', (event) => {
            errorHandler.handle(event.error, 'Global');
        });
        
        window.addEventListener('unhandledrejection', (event) => {
            errorHandler.handle(new Error(event.reason), 'Unhandled Promise');
        });
        
        // Debug info
        if (config.debug) {
            console.log('🚀 Ekash Core initialized', {
                version: config.version,
                theme: theme.current,
                device: utils.getDeviceInfo()
            });
        }
        
        performanceMonitor.mark('core-init-end');
        performanceMonitor.measure('core-init', 'core-init-start', 'core-init-end');
        
        // Trigger ready event
        eventSystem.trigger('coreReady', { version: config.version });
    }

    // Public API
    window.EkashCore = {
        // Config
        config: config,
        
        // Utilities
        utils: utils,
        $: utils.$,
        $$: utils.$$,
        
        // Event system
        on: eventSystem.on.bind(eventSystem),
        off: eventSystem.off.bind(eventSystem),
        trigger: eventSystem.trigger.bind(eventSystem),
        triggerEvent: eventSystem.trigger.bind(eventSystem), // Legacy alias
        
        // Theme system
        theme: themeSystem,
        toggleTheme: themeSystem.toggle.bind(themeSystem),
        
        // Performance monitoring
        performance: performanceMonitor,
        
        // Animation system
        animate: animationSystem,
        
        // Error handling
        error: errorHandler,
        
        // Currency formatting
        formatCurrency: utils.formatCurrency,
        formatDate: utils.formatDate,
        formatRelativeTime: utils.formatRelativeTime,
        
        // Initialize
        init: init
    };

    // Auto-initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();