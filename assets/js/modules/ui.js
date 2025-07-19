/**
 * Ekash UI Module - Enhanced Modern Version
 * @version 3.0.0
 * @description Enhanced UI components, animations, and user interactions
 */

(function() {
    'use strict';

    // Wait for core to be ready
    if (!window.EkashCore) {
        console.error('EkashUI requires EkashCore to be loaded first');
        return;
    }

    // UI configuration
    const config = {
        debug: true,
        animations: {
            duration: 300,
            easing: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)'
        },
        notifications: {
            position: 'top-right',
            duration: 5000,
            maxVisible: 5
        },
        components: {
            tooltip: {
                delay: 500,
                placement: 'top'
            },
            modal: {
                backdrop: true,
                keyboard: true
            },
            ripple: {
                duration: 600,
                color: 'rgba(255, 255, 255, 0.3)'
            }
        }
    };

    // UI state
    const state = {
        notifications: [],
        modals: new Map(),
        tooltips: new Map(),
        sidebar: {
            collapsed: false,
            mobile: false
        },
        loading: new Set(),
        ripples: new Map()
    };

    // Enhanced notification system
    const notifications = {
        // Show notification
        show: function(message, type = 'info', options = {}) {
            const id = EkashCore.utils.generateUUID();
            const notification = {
                id: id,
                message: message,
                type: type,
                timestamp: Date.now(),
                options: { ...config.notifications, ...options }
            };

            // Add to state
            state.notifications.push(notification);

            // Create DOM element
            const element = this.createElement(notification);
            
            // Add to container
            const container = this.getContainer();
            container.appendChild(element);

            // Animate in
            EkashCore.animate.slideIn(element, 'right');

            // Auto-hide if duration is set
            if (notification.options.duration > 0) {
                setTimeout(() => {
                    this.hide(id);
                }, notification.options.duration);
            }

            // Clean up old notifications
            this.cleanup();

            // Trigger event
            EkashCore.trigger('notificationShown', notification);

            return id;
        },

        // Hide notification
        hide: function(id) {
            const notification = state.notifications.find(n => n.id === id);
            if (!notification) return;

            const element = document.querySelector(`[data-notification-id="${id}"]`);
            if (element) {
                EkashCore.animate.fadeOut(element).then(() => {
                    element.remove();
                });
            }

            // Remove from state
            state.notifications = state.notifications.filter(n => n.id !== id);

            // Trigger event
            EkashCore.trigger('notificationHidden', { id });
        },

        // Create notification element
        createElement: function(notification) {
            const element = document.createElement('div');
            element.className = `notification notification-${notification.type}`;
            element.setAttribute('data-notification-id', notification.id);
            
            const iconMap = {
                success: 'check_circle',
                error: 'error',
                warning: 'warning',
                info: 'info'
            };

            element.innerHTML = `
                <div class="notification-content">
                    <div class="notification-icon">
                        <i class="material-icons-round">${iconMap[notification.type] || 'info'}</i>
                    </div>
                    <div class="notification-message">
                        ${notification.message}
                    </div>
                    <button class="notification-close" onclick="EkashUI.notifications.hide('${notification.id}')">
                        <i class="material-icons-round">close</i>
                    </button>
                </div>
                <div class="notification-progress"></div>
            `;

            // Add progress bar animation
            if (notification.options.duration > 0) {
                const progressBar = element.querySelector('.notification-progress');
                progressBar.style.animation = `notification-progress ${notification.options.duration}ms linear`;
            }

            return element;
        },

        // Get or create notification container
        getContainer: function() {
            let container = document.getElementById('notification-container');
            if (!container) {
                container = document.createElement('div');
                container.id = 'notification-container';
                container.className = `notification-container position-${config.notifications.position}`;
                document.body.appendChild(container);
            }
            return container;
        },

        // Clean up old notifications
        cleanup: function() {
            if (state.notifications.length > config.notifications.maxVisible) {
                const oldestId = state.notifications[0].id;
                this.hide(oldestId);
            }
        },

        // Clear all notifications
        clear: function() {
            state.notifications.forEach(notification => {
                this.hide(notification.id);
            });
        }
    };

    // Enhanced modal system
    const modals = {
        // Show modal
        show: function(modalId, options = {}) {
            const modal = document.getElementById(modalId);
            if (!modal) {
                console.error(`Modal ${modalId} not found`);
                return;
            }

            const modalOptions = { ...config.components.modal, ...options };
            
            // Store modal state
            state.modals.set(modalId, {
                element: modal,
                options: modalOptions,
                backdrop: null
            });

            // Create backdrop
            if (modalOptions.backdrop) {
                this.createBackdrop(modalId);
            }

            // Show modal
            modal.style.display = 'block';
            modal.classList.add('show');
            
            // Animate in
            EkashCore.animate.scale(modal, 0.9, 1);

            // Focus management
            this.manageFocus(modal);

            // Trigger event
            EkashCore.trigger('modalShown', { id: modalId, options: modalOptions });
        },

        // Hide modal
        hide: function(modalId) {
            const modalState = state.modals.get(modalId);
            if (!modalState) return;

            const modal = modalState.element;

            // Animate out
            EkashCore.animate.scale(modal, 1, 0.9).then(() => {
                modal.style.display = 'none';
                modal.classList.remove('show');
            });

            // Remove backdrop
            if (modalState.backdrop) {
                modalState.backdrop.remove();
            }

            // Clean up state
            state.modals.delete(modalId);

            // Trigger event
            EkashCore.trigger('modalHidden', { id: modalId });
        },

        // Create backdrop
        createBackdrop: function(modalId) {
            const backdrop = document.createElement('div');
            backdrop.className = 'modal-backdrop';
            backdrop.addEventListener('click', () => {
                this.hide(modalId);
            });
            
            document.body.appendChild(backdrop);
            
            // Store reference
            const modalState = state.modals.get(modalId);
            modalState.backdrop = backdrop;
            
            // Animate in
            EkashCore.animate.fadeIn(backdrop);
        },

        // Manage focus
        manageFocus: function(modal) {
            const focusableElements = modal.querySelectorAll(
                'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
            );
            
            if (focusableElements.length > 0) {
                focusableElements[0].focus();
            }
        }
    };

    // Enhanced ripple effect system
    const ripples = {
        // Add ripple effect
        add: function(element, event) {
            const ripple = document.createElement('div');
            ripple.className = 'ripple-effect';
            
            const rect = element.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = event.clientX - rect.left - size / 2;
            const y = event.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.style.background = config.components.ripple.color;
            
            element.appendChild(ripple);
            
            // Remove after animation
            setTimeout(() => {
                ripple.remove();
            }, config.components.ripple.duration);
        },

        // Initialize ripple effects
        init: function() {
            document.addEventListener('click', (event) => {
                if (event.target instanceof Element) {
                    const element = event.target.closest('.ripple, .btn');
                    if (element && !element.classList.contains('no-ripple')) {
                        this.add(element, event);
                    }
                }
            });
        }
    };

    // Enhanced sidebar system
    const sidebar = {
        // Toggle sidebar
        toggle: function() {
            const sidebar = document.querySelector('.sidebar');
            if (!sidebar) return;

            state.sidebar.collapsed = !state.sidebar.collapsed;
            
            if (state.sidebar.collapsed) {
                sidebar.classList.add('collapsed');
            } else {
                sidebar.classList.remove('collapsed');
            }

            // Trigger event
            EkashCore.trigger('sidebarToggled', { collapsed: state.sidebar.collapsed });
        },

        // Initialize sidebar
        init: function() {
            const sidebar = document.querySelector('.sidebar');
            if (!sidebar) return;

            // Mobile detection
            const checkMobile = () => {
                const isMobile = window.innerWidth < 768;
                if (isMobile !== state.sidebar.mobile) {
                    state.sidebar.mobile = isMobile;
                    
                    if (isMobile) {
                        sidebar.classList.add('mobile');
                    } else {
                        sidebar.classList.remove('mobile');
                    }
                }
            };

            checkMobile();
            window.addEventListener('resize', EkashCore.utils.debounce(checkMobile, 200));

            // Auto-hide on mobile after navigation
            if (state.sidebar.mobile) {
                sidebar.addEventListener('click', (event) => {
                    if (event.target.closest('.nav-link')) {
                        this.toggle();
                    }
                });
            }
        }
    };

    // Enhanced button system
    const buttons = {
        // Set button loading state
        setLoading: function(button, loading = true) {
            if (loading) {
                button.disabled = true;
                button.setAttribute('data-original-text', button.textContent);
                button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Yükleniyor...';
                button.classList.add('loading');
            } else {
                button.disabled = false;
                button.textContent = button.getAttribute('data-original-text') || 'Kaydet';
                button.classList.remove('loading');
            }
        },

        // Reset button
        reset: function(button) {
            this.setLoading(button, false);
        },

        // Initialize button enhancements
        init: function() {
            // Add loading state to form submissions
            document.addEventListener('submit', (event) => {
                const form = event.target;
                const submitButton = form.querySelector('button[type="submit"]');
                
                if (submitButton) {
                    this.setLoading(submitButton);
                }
            });

            // Add hover effects
            document.addEventListener('mouseenter', (event) => {
                if (event.target instanceof Element) {
                    const button = event.target.closest('.btn');
                    if (button) {
                        button.classList.add('hover');
                    }
                }
            }, true);

            document.addEventListener('mouseleave', (event) => {
                if (event.target instanceof Element) {
                    const button = event.target.closest('.btn');
                    if (button) {
                        button.classList.remove('hover');
                    }
                }
            }, true);
        }
    };

    // Enhanced tooltip system
    const tooltips = {
        // Show tooltip
        show: function(element, text, options = {}) {
            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip-enhanced';
            tooltip.textContent = text;
            
            const tooltipOptions = { ...config.components.tooltip, ...options };
            
            // Position tooltip
            this.position(tooltip, element, tooltipOptions.placement);
            
            document.body.appendChild(tooltip);
            
            // Animate in
            EkashCore.animate.fadeIn(tooltip);
            
            // Store reference
            state.tooltips.set(element, tooltip);
            
            return tooltip;
        },

        // Hide tooltip
        hide: function(element) {
            const tooltip = state.tooltips.get(element);
            if (tooltip) {
                EkashCore.animate.fadeOut(tooltip).then(() => {
                    tooltip.remove();
                });
                state.tooltips.delete(element);
            }
        },

        // Position tooltip
        position: function(tooltip, element, placement) {
            const rect = element.getBoundingClientRect();
            const tooltipRect = tooltip.getBoundingClientRect();
            
            let top, left;
            
            switch (placement) {
                case 'top':
                    top = rect.top - tooltipRect.height - 8;
                    left = rect.left + (rect.width - tooltipRect.width) / 2;
                    break;
                case 'bottom':
                    top = rect.bottom + 8;
                    left = rect.left + (rect.width - tooltipRect.width) / 2;
                    break;
                case 'left':
                    top = rect.top + (rect.height - tooltipRect.height) / 2;
                    left = rect.left - tooltipRect.width - 8;
                    break;
                case 'right':
                    top = rect.top + (rect.height - tooltipRect.height) / 2;
                    left = rect.right + 8;
                    break;
            }
            
            tooltip.style.top = top + 'px';
            tooltip.style.left = left + 'px';
        },

        // Initialize tooltips
        init: function() {
            let timeout;
            
            document.addEventListener('mouseenter', (event) => {
                if (event.target instanceof Element) {
                    const element = event.target.closest('[data-tooltip]');
                    if (element) {
                        timeout = setTimeout(() => {
                            const text = element.getAttribute('data-tooltip');
                            const placement = element.getAttribute('data-tooltip-placement') || 'top';
                            this.show(element, text, { placement });
                        }, config.components.tooltip.delay);
                    }
                }
            });

            document.addEventListener('mouseleave', (event) => {
                if (event.target instanceof Element) {
                    const element = event.target.closest('[data-tooltip]');
                    if (element) {
                        clearTimeout(timeout);
                        this.hide(element);
                    }
                }
            });
        }
    };

    // Enhanced loading system
    const loading = {
        // Show loading
        show: function(element) {
            element.classList.add('loading');
            state.loading.add(element);
            
            // Create loading overlay
            const overlay = document.createElement('div');
            overlay.className = 'loading-overlay';
            overlay.innerHTML = `
                <div class="loading-spinner">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Yükleniyor...</span>
                    </div>
                </div>
            `;
            
            element.appendChild(overlay);
            
            // Animate in
            EkashCore.animate.fadeIn(overlay);
        },

        // Hide loading
        hide: function(element) {
            element.classList.remove('loading');
            state.loading.delete(element);
            
            const overlay = element.querySelector('.loading-overlay');
            if (overlay) {
                EkashCore.animate.fadeOut(overlay).then(() => {
                    overlay.remove();
                });
            }
        },

        // Toggle loading
        toggle: function(element) {
            if (state.loading.has(element)) {
                this.hide(element);
            } else {
                this.show(element);
            }
        }
    };

    // Enhanced scroll system
    const scroll = {
        // Smooth scroll to element
        to: function(element, options = {}) {
            const targetElement = typeof element === 'string' ? document.querySelector(element) : element;
            if (!targetElement) return;

            const defaultOptions = {
                behavior: 'smooth',
                block: 'start',
                inline: 'nearest'
            };

            targetElement.scrollIntoView({ ...defaultOptions, ...options });
        },

        // Get scroll position
        getPosition: function() {
            return {
                x: window.pageXOffset || document.documentElement.scrollLeft,
                y: window.pageYOffset || document.documentElement.scrollTop
            };
        },

        // Initialize scroll enhancements
        init: function() {
            // Smooth scroll for anchor links
            document.addEventListener('click', (event) => {
                if (event.target instanceof Element) {
                    const link = event.target.closest('a[href^="#"]');
                    if (link) {
                        const href = link.getAttribute('href');
                        if (href !== '#') {
                            const target = document.querySelector(href);
                            if (target) {
                                event.preventDefault();
                                this.to(target);
                            }
                        }
                    }
                }
            });

            // Scroll to top button
            const scrollTopBtn = document.querySelector('.scroll-top');
            if (scrollTopBtn) {
                window.addEventListener('scroll', EkashCore.utils.throttle(() => {
                    if (window.pageYOffset > 300) {
                        scrollTopBtn.classList.add('visible');
                    } else {
                        scrollTopBtn.classList.remove('visible');
                    }
                }, 100));

                scrollTopBtn.addEventListener('click', () => {
                    this.to(document.body);
                });
            }
        }
    };

    // Initialize UI system
    function init() {
        EkashCore.performance.mark('ui-init-start');
        
        // Initialize components
        ripples.init();
        sidebar.init();
        buttons.init();
        tooltips.init();
        scroll.init();
        
        // Setup responsive handling
        window.addEventListener('resize', EkashCore.utils.debounce(() => {
            EkashCore.trigger('windowResized', EkashCore.utils.getDeviceInfo());
        }, 250));
        
        // Debug info
        if (config.debug) {
            console.log('🎨 Ekash UI initialized');
        }
        
        EkashCore.performance.mark('ui-init-end');
        EkashCore.performance.measure('ui-init', 'ui-init-start', 'ui-init-end');
        
        // Trigger ready event
        EkashCore.trigger('uiReady');
    }

    // Public API
    window.EkashUI = {
        // Configuration
        config: config,
        
        // Components
        notifications: notifications,
        modals: modals,
        ripples: ripples,
        sidebar: sidebar,
        buttons: buttons,
        tooltips: tooltips,
        loading: loading,
        scroll: scroll,
        
        // Convenience methods
        showSnackbar: notifications.show.bind(notifications),
        showNotification: notifications.show.bind(notifications),
        showModal: modals.show.bind(modals),
        hideModal: modals.hide.bind(modals),
        toggleSidebar: sidebar.toggle.bind(sidebar),
        setButtonLoading: buttons.setLoading.bind(buttons),
        resetButton: buttons.reset.bind(buttons),
        
        // Initialize
        init: init
    };

    // Auto-initialize when core is ready
    EkashCore.on('coreReady', init);

})();