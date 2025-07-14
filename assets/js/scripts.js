/**
 * Ekash Main Scripts - Modular Architecture Entry Point
 * @version 2.0.0
 * @description Modern modular JavaScript architecture for Ekash Budget Management System
 * 
 * This file serves as the main entry point for the modular JavaScript system.
 * It loads and coordinates all modules and provides legacy compatibility.
 * 
 * Modules loaded:
 * - EkashCore: Core utilities, theme management, events
 * - EkashUI: User interface components, sidebar, ripple effects
 * - EkashForms: Form validation, AJAX handling
 * - EkashNavigation: Menu management, routing, active states
 * 
 * @requires jQuery (for legacy compatibility)
 * @requires Bootstrap 5.x
 */

(function() {
    'use strict';

    // Module loading status
    const moduleStatus = {
        core: false,
        ui: false,
        forms: false,
        navigation: false
    };

    // Configuration
    const config = {
        debug: true, // Set to false in production
        legacy: true, // Keep legacy support for now
        modules: {
            required: ['core', 'ui', 'forms', 'navigation'],
            optional: ['charts', 'analytics']
        }
    };

    /**
     * Debug logging (only in debug mode)
     */
    function debugLog(message, data = null) {
        if (config.debug) {
            console.log(`🚀 Ekash Scripts: ${message}`, data || '');
        }
    }

    /**
     * Initialize main application
     */
    function initApp() {
        debugLog('Starting Ekash application initialization...');

        // Check if all required modules are loaded
        if (!checkModulesLoaded()) {
            console.error('❌ Required modules not loaded. Check module loading order.');
            return false;
        }

        debugLog('✅ All required modules loaded successfully');

        // Initialize legacy support if needed
        if (config.legacy) {
            initLegacySupport();
        }

        // Initialize application-specific features
        initAppFeatures();

        // Setup global error handling
        setupGlobalErrorHandling();

        // Initialize performance monitoring
        if (config.debug) {
            initPerformanceMonitoring();
        }

        debugLog('🎉 Ekash application initialized successfully');
        
        // Trigger app ready event
        if (window.EkashCore) {
            EkashCore.triggerEvent('appReady', {
                modules: moduleStatus,
                timestamp: Date.now()
            });
        }

        return true;
    }

    /**
     * Check if all required modules are loaded
     */
    function checkModulesLoaded() {
        const requiredModules = config.modules.required;
        let allLoaded = true;

        requiredModules.forEach(module => {
            const moduleName = `Ekash${module.charAt(0).toUpperCase() + module.slice(1)}`;
            
            if (window[moduleName] && typeof window[moduleName].init === 'function') {
                moduleStatus[module] = true;
                debugLog(`✅ Module loaded: ${moduleName}`);
            } else {
                moduleStatus[module] = false;
                console.error(`❌ Module not loaded: ${moduleName}`);
                allLoaded = false;
            }
        });

        return allLoaded;
    }

    /**
     * Initialize legacy support for backward compatibility
     */
    function initLegacySupport() {
        debugLog('Initializing legacy support...');

        // Ensure jQuery compatibility
        if (typeof $ !== 'undefined' && typeof jQuery !== 'undefined') {
            // Legacy content body height adjustment
            $('.content-body').css({ 
                'min-height': (($(window).height())) + 50 + 'px' 
            });

            // Legacy active page highlighting (kept for compatibility)
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
                    if (!o.is("li")) break
                    o = o.parent().addClass("show").parent().addClass("active")
                }
            });

            debugLog('✅ jQuery legacy support initialized');
        }

        // Legacy global functions for backward compatibility
        if (!window.themeToggle && window.EkashCore) {
            window.themeToggle = () => EkashCore.toggleTheme();
        }

        if (!window.showSnackbar && window.EkashUI) {
            window.showSnackbar = (message, type) => EkashUI.showSnackbar(message, type);
        }

        debugLog('✅ Legacy support initialized');
    }

    /**
     * Initialize application-specific features
     */
    function initAppFeatures() {
        debugLog('Initializing application features...');

        // FAB (Floating Action Button) functionality
        initFAB();

        // Enhanced interactions
        initEnhancedInteractions();

        // Auto-save functionality
        initAutoSave();

        // Keyboard shortcuts
        initKeyboardShortcuts();

        debugLog('✅ Application features initialized');
    }

    /**
     * Initialize FAB (Floating Action Button)
     */
    function initFAB() {
        const fabMain = document.getElementById('fabMain');
        const fabOptions = document.getElementById('fabOptions');
        
        if (!fabMain || !fabOptions) {
            debugLog('⚠️ FAB elements not found, skipping FAB initialization');
            return;
        }

        // FAB toggle functionality
        fabMain.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            
            const fabContainer = document.querySelector('.fab-container');
            if (fabContainer) {
                fabContainer.classList.toggle('active');
                
                if (window.EkashCore) {
                    EkashCore.triggerEvent('fabToggled', {
                        isActive: fabContainer.classList.contains('active')
                    });
                }
            }
        });

        // Close FAB when clicking outside
        document.addEventListener('click', (e) => {
            const fabContainer = document.querySelector('.fab-container');
            if (fabContainer && !fabContainer.contains(e.target)) {
                fabContainer.classList.remove('active');
            }
        });

        // FAB option handlers
        const fabOptionButtons = document.querySelectorAll('.fab-option');
        fabOptionButtons.forEach(button => {
            button.addEventListener('click', () => {
                const action = button.getAttribute('data-action');
                const fabContainer = document.querySelector('.fab-container');
                
                if (fabContainer) {
                    fabContainer.classList.remove('active');
                }
                
                handleFABAction(action);
            });
        });

        debugLog('✅ FAB initialized');
    }

    /**
     * Handle FAB action
     */
    function handleFABAction(action) {
        const modalMapping = {
            'import-favorites': 'importFavoritesModal',
            'add-from-link': 'addFromLinkModal',
            'bulk-add': 'bulkAddModal',
            'import-notes': 'importNotesModal'
        };

        const modalId = modalMapping[action];
        if (modalId) {
            const modal = document.getElementById(modalId);
            if (modal && typeof bootstrap !== 'undefined') {
                const bsModal = new bootstrap.Modal(modal);
                bsModal.show();
            }
        }

        if (window.EkashCore) {
            EkashCore.triggerEvent('fabActionTriggered', { action });
        }

        debugLog(`FAB action triggered: ${action}`);
    }

    /**
     * Initialize enhanced interactions
     */
    function initEnhancedInteractions() {
        // Enhanced hover effects
        const cards = document.querySelectorAll('.card, .stat-card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.classList.add('hover-effect');
            });
            
            card.addEventListener('mouseleave', () => {
                card.classList.remove('hover-effect');
            });
        });

        // Enhanced focus management
        const formElements = document.querySelectorAll('input, textarea, select');
        formElements.forEach(element => {
            element.addEventListener('focus', () => {
                element.closest('.form-group, .mb-3, .form-floating')?.classList.add('focused');
            });
            
            element.addEventListener('blur', () => {
                element.closest('.form-group, .mb-3, .form-floating')?.classList.remove('focused');
            });
        });

        debugLog('✅ Enhanced interactions initialized');
    }

    /**
     * Initialize auto-save functionality
     */
    function initAutoSave() {
        const autoSaveForms = document.querySelectorAll('[data-autosave]');
        
        autoSaveForms.forEach(form => {
            const saveInterval = parseInt(form.getAttribute('data-autosave')) || 30000; // 30 seconds default
            
            let autoSaveTimer;
            const formInputs = form.querySelectorAll('input, textarea, select');
            
            formInputs.forEach(input => {
                input.addEventListener('input', () => {
                    clearTimeout(autoSaveTimer);
                    autoSaveTimer = setTimeout(() => {
                        saveFormData(form);
                    }, saveInterval);
                });
            });
        });

        debugLog(`✅ Auto-save initialized for ${autoSaveForms.length} forms`);
    }

    /**
     * Save form data to localStorage
     */
    function saveFormData(form) {
        const formData = new FormData(form);
        const formId = form.id || 'unnamed_form';
        const data = {};
        
        for (let [key, value] of formData.entries()) {
            data[key] = value;
        }
        
        try {
            localStorage.setItem(`ekash_autosave_${formId}`, JSON.stringify({
                data: data,
                timestamp: Date.now()
            }));
            
            debugLog(`Auto-saved form data for: ${formId}`);
            
            if (window.EkashCore) {
                EkashCore.triggerEvent('formAutoSaved', { formId, data });
            }
        } catch (e) {
            console.warn('Auto-save failed:', e);
        }
    }

    /**
     * Initialize keyboard shortcuts
     */
    function initKeyboardShortcuts() {
        document.addEventListener('keydown', (e) => {
            // Ctrl/Cmd + S: Save current form
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                const activeForm = document.querySelector('form:focus-within');
                if (activeForm) {
                    activeForm.dispatchEvent(new Event('submit', { bubbles: true }));
                }
            }
            
            // Ctrl/Cmd + K: Search
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                const searchInput = document.querySelector('input[type="search"], .search-input');
                if (searchInput) {
                    searchInput.focus();
                }
            }
            
            // Ctrl/Cmd + B: Toggle sidebar
            if ((e.ctrlKey || e.metaKey) && e.key === 'b') {
                e.preventDefault();
                if (window.EkashUI) {
                    EkashUI.toggleSidebar();
                }
            }
            
            // Ctrl/Cmd + D: Toggle dark mode
            if ((e.ctrlKey || e.metaKey) && e.key === 'd') {
                e.preventDefault();
                if (window.EkashCore) {
                    EkashCore.toggleTheme();
                }
            }
        });

        debugLog('✅ Keyboard shortcuts initialized');
    }

    /**
     * Setup global error handling
     */
    function setupGlobalErrorHandling() {
        // Global error handler
        window.addEventListener('error', (e) => {
            console.error('Global error:', e.error);
            
            if (window.EkashCore) {
                EkashCore.triggerEvent('globalError', {
                    message: e.message,
                    filename: e.filename,
                    lineno: e.lineno,
                    colno: e.colno,
                    error: e.error
                });
            }
        });

        // Unhandled promise rejection handler
        window.addEventListener('unhandledrejection', (e) => {
            console.error('Unhandled promise rejection:', e.reason);
            
            if (window.EkashCore) {
                EkashCore.triggerEvent('unhandledRejection', {
                    reason: e.reason
                });
            }
        });

        debugLog('✅ Global error handling setup complete');
    }

    /**
     * Initialize performance monitoring
     */
    function initPerformanceMonitoring() {
        // Monitor page load performance
        if ('performance' in window) {
            window.addEventListener('load', () => {
                setTimeout(() => {
                    const perfData = performance.getEntriesByType('navigation')[0];
                    if (perfData) {
                        debugLog('Performance metrics:', {
                            loadTime: perfData.loadEventEnd - perfData.loadEventStart,
                            domContentLoaded: perfData.domContentLoadedEventEnd - perfData.domContentLoadedEventStart,
                            totalTime: perfData.loadEventEnd - perfData.fetchStart
                        });
                    }
                }, 1000);
            });
        }

        // Monitor memory usage (if available)
        if ('memory' in performance) {
            setInterval(() => {
                const memory = performance.memory;
                if (memory.usedJSHeapSize > memory.jsHeapSizeLimit * 0.9) {
                    console.warn('⚠️ High memory usage detected');
                }
            }, 30000);
        }

        debugLog('✅ Performance monitoring initialized');
    }

    /**
     * Module loading queue
     */
    const moduleLoadQueue = [];
    let modulesReady = false;

    /**
     * Add module to loading queue
     */
    function queueModuleInit(callback) {
        if (modulesReady) {
            callback();
        } else {
            moduleLoadQueue.push(callback);
        }
    }

    /**
     * Process module loading queue
     */
    function processModuleQueue() {
        modulesReady = true;
        while (moduleLoadQueue.length > 0) {
            const callback = moduleLoadQueue.shift();
            try {
                callback();
            } catch (e) {
                console.error('Error processing module queue:', e);
            }
        }
    }

    /**
     * Initialize when DOM is ready
     */
    function domReady(callback) {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', callback);
        } else {
            callback();
        }
    }

    /**
     * Main initialization
     */
    domReady(() => {
        debugLog('DOM ready, waiting for modules...');
        
        // Wait a bit for modules to load
        setTimeout(() => {
            const success = initApp();
            if (success) {
                processModuleQueue();
            }
        }, 100);
    });

    // Public API
    window.EkashApp = {
        init: initApp,
        queueModuleInit: queueModuleInit,
        config: config,
        moduleStatus: moduleStatus,
        debugLog: debugLog
    };

    debugLog('Main scripts loaded');

})();

// Legacy jQuery compatibility wrapper (if needed)
if (typeof $ !== 'undefined') {
    $(document).ready(function() {
        // Any jQuery-specific legacy code can go here
        console.log('jQuery legacy wrapper ready');
    });
}

/**
 * Export for modern module systems
 */
if (typeof module !== 'undefined' && module.exports) {
    module.exports = window.EkashApp;
}