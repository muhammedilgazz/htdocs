/**
 * Ekash UI Module - User Interface components and interactions
 * @version 1.0.0
 * @requires EkashCore
 */

const EkashUI = (function() {
    'use strict';

    // Private variables
    let isInitialized = false;
    const selectors = {
        sidebar: '.sidebar',
        sidebarToggle: '#sidebarToggle',
        rippleElements: '.ripple',
        loadingButtons: '.btn[data-loading]',
        submenuToggle: '[data-bs-target="#harcamalarSubmenu"]',
        submenu: '#harcamalarSubmenu',
        smoothScrollLinks: 'a[href^="#"]:not([data-bs-toggle])',
        fabContainer: '.fab-container',
        fabMain: '#fabMain',
        fabOptions: '.fab-option'
    };

    const config = {
        mobile: {
            breakpoint: 1024
        },
        animation: {
            duration: 300,
            rippleDuration: 600
        },
        snackbar: {
            duration: 3000,
            fadeIn: 100,
            fadeOut: 300
        }
    };

    /**
     * Initialize UI module
     */
    function init() {
        if (isInitialized) {
            console.warn('EkashUI already initialized');
            return;
        }

        console.log('🎨 Ekash UI initializing...');

        // Wait for DOM to be ready
        EkashCore.ready(() => {
            initSidebar();
            initRippleEffect();
            initLoadingButtons();
            initSubmenu();
            initSmoothScroll();
            initFloatingActionButton();
            initGlobalUIEvents();
        });

        isInitialized = true;
        console.log('✅ Ekash UI initialized successfully');
    }

    /**
     * Initialize sidebar functionality
     */
    function initSidebar() {
        const sidebar = document.querySelector(selectors.sidebar);
        const sidebarToggle = document.querySelector(selectors.sidebarToggle);

        if (!sidebar || !sidebarToggle) {
            console.warn('Sidebar elements not found');
            return;
        }

        // Toggle sidebar
        sidebarToggle.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            toggleSidebar();
        });

        // Close sidebar when clicking outside (mobile only)
        document.addEventListener('click', (e) => {
            if (EkashCore.isMobile()) {
                if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                    closeSidebar();
                }
            }
        });

        // Handle window resize
        EkashCore.on('windowResized', (e) => {
            if (e.detail.width > config.mobile.breakpoint) {
                closeSidebar();
            }
        });

        console.log('✅ Sidebar initialized');
    }

    /**
     * Toggle sidebar visibility
     */
    function toggleSidebar() {
        const sidebar = document.querySelector(selectors.sidebar);
        if (sidebar) {
            sidebar.classList.toggle('show');
            
            // Trigger event
            EkashCore.triggerEvent('sidebarToggled', {
                isOpen: sidebar.classList.contains('show')
            });
        }
    }

    /**
     * Close sidebar
     */
    function closeSidebar() {
        const sidebar = document.querySelector(selectors.sidebar);
        if (sidebar) {
            sidebar.classList.remove('show');
            
            // Trigger event
            EkashCore.triggerEvent('sidebarClosed');
        }
    }

    /**
     * Open sidebar
     */
    function openSidebar() {
        const sidebar = document.querySelector(selectors.sidebar);
        if (sidebar) {
            sidebar.classList.add('show');
            
            // Trigger event
            EkashCore.triggerEvent('sidebarOpened');
        }
    }

    /**
     * Initialize Material Design ripple effect
     */
    function initRippleEffect() {
        const rippleElements = document.querySelectorAll(selectors.rippleElements);
        
        rippleElements.forEach(element => {
            element.addEventListener('click', createRipple);
        });

        console.log(`✅ Ripple effect initialized for ${rippleElements.length} elements`);
    }

    /**
     * Create ripple effect on element
     */
    function createRipple(event) {
        const button = event.currentTarget;
        
        // Remove existing ripple
        const existingRipple = button.querySelector('.ripple-effect');
        if (existingRipple) {
            existingRipple.remove();
        }
        
        // Create new ripple element
        const ripple = EkashCore.createElement('span', {
            className: 'ripple-effect'
        });
        
        // Calculate ripple size and position
        const rect = button.getBoundingClientRect();
        const diameter = Math.max(button.clientWidth, button.clientHeight);
        const radius = diameter / 2;
        
        // Set ripple styles
        ripple.style.width = ripple.style.height = `${diameter}px`;
        ripple.style.left = `${event.clientX - rect.left - radius}px`;
        ripple.style.top = `${event.clientY - rect.top - radius}px`;
        
        // Add ripple to button
        button.appendChild(ripple);
        
        // Remove ripple after animation
        setTimeout(() => {
            if (ripple.parentNode) {
                ripple.remove();
            }
        }, config.animation.rippleDuration);
    }

    /**
     * Initialize loading button states
     */
    function initLoadingButtons() {
        const loadingButtons = document.querySelectorAll(selectors.loadingButtons);
        
        loadingButtons.forEach(button => {
            // Store original text
            button.setAttribute('data-original-text', button.innerHTML);
            
            button.addEventListener('click', function() {
                if (!this.classList.contains('btn-loading')) {
                    setButtonLoading(this);
                    
                    // Auto-remove loading state after demo period
                    setTimeout(() => {
                        setButtonComplete(this);
                    }, 2000);
                }
            });
        });

        console.log(`✅ Loading buttons initialized for ${loadingButtons.length} elements`);
    }

    /**
     * Set button to loading state
     */
    function setButtonLoading(button, text = 'Yükleniyor...') {
        button.classList.add('btn-loading');
        button.disabled = true;
        button.innerHTML = `<span class="loading"></span> ${text}`;
        
        // Trigger event
        EkashCore.triggerEvent('buttonLoading', { button });
    }

    /**
     * Set button to complete state
     */
    function setButtonComplete(button, text = null) {
        button.classList.remove('btn-loading');
        button.disabled = false;
        
        const completeText = text || button.getAttribute('data-original-text') || 'Tamamlandı';
        button.innerHTML = completeText;
        
        // Trigger event
        EkashCore.triggerEvent('buttonComplete', { button });
    }

    /**
     * Reset button to original state
     */
    function resetButton(button) {
        button.classList.remove('btn-loading');
        button.disabled = false;
        
        const originalText = button.getAttribute('data-original-text');
        if (originalText) {
            button.innerHTML = originalText;
        }
        
        // Trigger event
        EkashCore.triggerEvent('buttonReset', { button });
    }

    /**
     * Initialize submenu functionality
     */
    function initSubmenu() {
        const submenuToggle = document.querySelector(selectors.submenuToggle);
        const submenu = document.querySelector(selectors.submenu);
        
        if (!submenuToggle || !submenu) {
            console.warn('Submenu elements not found');
            return;
        }

        // Check if submenu should be open on page load
        const activeSubmenuItem = submenu.querySelector('.nav-link.active');
        if (activeSubmenuItem) {
            submenu.classList.add('show');
            submenuToggle.setAttribute('aria-expanded', 'true');
        }

        // Toggle submenu
        submenuToggle.addEventListener('click', (e) => {
            e.preventDefault();
            toggleSubmenu();
        });

        // Close sidebar on submenu item click (mobile)
        const submenuItems = submenu.querySelectorAll('.nav-link');
        submenuItems.forEach(item => {
            item.addEventListener('click', () => {
                if (EkashCore.isMobile()) {
                    closeSidebar();
                }
            });
        });

        console.log('✅ Submenu initialized');
    }

    /**
     * Toggle submenu visibility
     */
    function toggleSubmenu() {
        const submenuToggle = document.querySelector(selectors.submenuToggle);
        const submenu = document.querySelector(selectors.submenu);
        
        if (!submenuToggle || !submenu) return;

        const isExpanded = submenuToggle.getAttribute('aria-expanded') === 'true';
        
        if (isExpanded) {
            submenu.classList.remove('show');
            submenuToggle.setAttribute('aria-expanded', 'false');
        } else {
            submenu.classList.add('show');
            submenuToggle.setAttribute('aria-expanded', 'true');
        }

        // Trigger event
        EkashCore.triggerEvent('submenuToggled', {
            isOpen: !isExpanded
        });
    }

    /**
     * Initialize smooth scrolling
     */
    function initSmoothScroll() {
        const smoothScrollLinks = document.querySelectorAll(selectors.smoothScrollLinks);
        
        smoothScrollLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                
                const targetId = link.getAttribute('href');
                const target = document.querySelector(targetId);
                
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        console.log(`✅ Smooth scroll initialized for ${smoothScrollLinks.length} links`);
    }

    /**
     * Material Design Snackbar
     */
    function showSnackbar(message, type = 'info', duration = config.snackbar.duration) {
        const snackbar = EkashCore.createElement('div', {
            className: 'snackbar'
        }, message);

        // Set snackbar color based on type
        const colors = {
            success: '#4caf50',
            error: '#f44336',
            warning: '#ff9800',
            info: '#2196f3'
        };

        snackbar.style.background = colors[type] || colors.info;
        
        // Add to DOM
        document.body.appendChild(snackbar);
        
        // Show snackbar
        setTimeout(() => {
            snackbar.classList.add('show');
        }, config.snackbar.fadeIn);
        
        // Hide and remove snackbar
        setTimeout(() => {
            snackbar.classList.remove('show');
            setTimeout(() => {
                if (snackbar.parentNode) {
                    snackbar.remove();
                }
            }, config.snackbar.fadeOut);
        }, duration);

        // Trigger event
        EkashCore.triggerEvent('snackbarShown', { message, type });
        
        return snackbar;
    }

    /**
     * Initialize Floating Action Button
     */
    function initFloatingActionButton() {
        const fabContainer = document.querySelector(selectors.fabContainer);
        const fabMain = document.querySelector(selectors.fabMain);
        const fabOptions = document.querySelectorAll(selectors.fabOptions);

        if (!fabContainer || !fabMain) {
            console.warn('FAB elements not found');
            return;
        }

        // FAB Toggle
        fabMain.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            fabContainer.classList.toggle('active');
        });

        // Close FAB when clicking outside
        document.addEventListener('click', (e) => {
            if (!fabContainer.contains(e.target)) {
                fabContainer.classList.remove('active');
            }
        });

        // FAB Option Click Handlers
        fabOptions.forEach(option => {
            option.addEventListener('click', (e) => {
                e.preventDefault();
                const action = option.getAttribute('data-action');
                fabContainer.classList.remove('active');
                
                // Trigger custom event for FAB action
                EkashCore.triggerEvent('fabAction', { action });
                
                // Handle specific actions
                switch(action) {
                    case 'import-favorites':
                        if (typeof bootstrap !== 'undefined') {
                            const modal = new bootstrap.Modal(document.getElementById('importFavoritesModal'));
                            modal.show();
                        }
                        break;
                    case 'add-from-link':
                        if (typeof bootstrap !== 'undefined') {
                            const modal = new bootstrap.Modal(document.getElementById('addFromLinkModal'));
                            modal.show();
                        }
                        break;
                    case 'bulk-add':
                        if (typeof bootstrap !== 'undefined') {
                            const modal = new bootstrap.Modal(document.getElementById('bulkAddModal'));
                            modal.show();
                        }
                        break;
                    case 'import-notes':
                        if (typeof bootstrap !== 'undefined') {
                            const modal = new bootstrap.Modal(document.getElementById('importNotesModal'));
                            modal.show();
                        }
                        break;
                }
            });
        });

        console.log('✅ Floating Action Button initialized');
    }

    /**
     * Initialize global UI event listeners
     */
    function initGlobalUIEvents() {
        // Escape key to close modals/sidebars
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeSidebar();
                EkashCore.triggerEvent('escapePressed');
            }
        });

        // Focus management for accessibility
        document.addEventListener('focusin', (e) => {
            if (e.target.matches('input, textarea, select')) {
                EkashCore.triggerEvent('formFieldFocused', { element: e.target });
            }
        });

        console.log('✅ Global UI events initialized');
    }

    /**
     * Add ripple effect to new elements
     */
    function addRippleToElement(element) {
        if (element && !element.hasAttribute('data-ripple-initialized')) {
            element.addEventListener('click', createRipple);
            element.setAttribute('data-ripple-initialized', 'true');
        }
    }

    /**
     * Initialize UI for dynamically added content
     */
    function initDynamicContent(container) {
        if (!container) return;

        // Add ripple effects to new elements
        const newRippleElements = container.querySelectorAll(selectors.rippleElements);
        newRippleElements.forEach(addRippleToElement);

        // Initialize loading buttons
        const newLoadingButtons = container.querySelectorAll(selectors.loadingButtons);
        newLoadingButtons.forEach(button => {
            button.setAttribute('data-original-text', button.innerHTML);
            button.addEventListener('click', function() {
                if (!this.classList.contains('btn-loading')) {
                    setButtonLoading(this);
                }
            });
        });

        console.log('✅ Dynamic content initialized');
    }

    /**
     * Public API
     */
    return {
        // Initialization
        init,
        initDynamicContent,
        
        // Sidebar controls
        toggleSidebar,
        openSidebar,
        closeSidebar,
        
        // Button states
        setButtonLoading,
        setButtonComplete,
        resetButton,
        
        // Submenu controls
        toggleSubmenu,
        
        // Notifications
        showSnackbar,
        
        // Ripple effect
        createRipple,
        addRippleToElement,
        
        // FAB controls
        initFloatingActionButton,
        
        // Config access
        config
    };
})();

// Auto-initialize when core is ready
EkashCore.ready(() => {
    EkashUI.init();
});

// Make snackbar globally available
window.showSnackbar = EkashUI.showSnackbar;

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = EkashUI;
}

// Global namespace
window.EkashUI = EkashUI;