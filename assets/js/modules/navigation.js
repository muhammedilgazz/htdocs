/**
 * Ekash Navigation Module - Enhanced Modern Version
 * @version 3.0.0
 * @description Enhanced navigation, routing, and menu management
 */

(function() {
    'use strict';

    // Wait for core to be ready
    if (!window.EkashCore) {
        console.error('EkashNavigation requires EkashCore to be loaded first');
        return;
    }

    // Navigation configuration
    const config = {
        debug: true,
        activeClass: 'active',
        collapseClass: 'show',
        animation: {
            duration: 300,
            easing: 'ease-in-out'
        },
        breadcrumb: {
            enabled: true,
            separator: '/'
        },
        history: {
            enabled: true,
            maxEntries: 50
        }
    };

    // Navigation state
    const state = {
        currentPath: window.location.pathname,
        history: [],
        menuItems: new Map(),
        breadcrumbs: [],
        sidebar: {
            collapsed: false,
            mobile: false
        }
    };

    // Menu management system
    const menu = {
        // Initialize menu
        init: function() {
            this.parseMenuItems();
            this.setupEventListeners();
            this.setActiveStates();
        },

        // Parse menu items from DOM
        parseMenuItems: function() {
            const menuLinks = document.querySelectorAll('.sidebar-nav .nav-link, .menu .nav-link');
            
            menuLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href && href !== '#') {
                    const menuItem = {
                        element: link,
                        href: href,
                        text: link.textContent.trim(),
                        icon: link.querySelector('i')?.className || '',
                        parent: link.closest('.nav-item'),
                        submenu: null,
                        level: 0
                    };

                    // Check if it's a submenu item
                    const submenuContainer = link.closest('.collapse');
                    if (submenuContainer) {
                        menuItem.level = 1;
                        menuItem.submenu = submenuContainer.id;
                    }

                    state.menuItems.set(href, menuItem);
                }
            });
        },

        // Setup event listeners
        setupEventListeners: function() {
            // Handle menu clicks
            document.addEventListener('click', (event) => {
                const link = event.target.closest('.nav-link');
                if (link && link.getAttribute('href')) {
                    this.handleMenuClick(link, event);
                }
            });

            // Handle submenu toggles
            document.addEventListener('click', (event) => {
                const toggle = event.target.closest('[data-bs-toggle="collapse"]');
                if (toggle) {
                    this.handleSubmenuToggle(toggle);
                }
            });

            // Handle browser navigation
            window.addEventListener('popstate', (event) => {
                this.handleBrowserNavigation(event);
            });
        },

        // Handle menu click
        handleMenuClick: function(link, event) {
            const href = link.getAttribute('href');
            
            // Skip if external link
            if (href.startsWith('http') || href.startsWith('mailto:')) {
                return;
            }
            
            // Skip if hash-only link
            if (href.startsWith('#')) {
                return;
            }
            
            // Add to history
            this.addToHistory(href, link.textContent.trim());
            
            // Update active states
            this.setActiveStates(href);
            
            // Trigger navigation event
            EkashCore.trigger('navigationChanged', {
                from: state.currentPath,
                to: href,
                element: link
            });
            
            // Update current path
            state.currentPath = href;
        },

        // Handle submenu toggle
        handleSubmenuToggle: function(toggle) {
            const target = toggle.getAttribute('data-bs-target');
            const submenu = document.querySelector(target);
            
            if (submenu) {
                const isExpanded = submenu.classList.contains(config.collapseClass);
                const icon = toggle.querySelector('.bi-chevron-down');
                
                if (icon) {
                    if (isExpanded) {
                        icon.style.transform = 'rotate(0deg)';
                    } else {
                        icon.style.transform = 'rotate(180deg)';
                    }
                }
                
                // Trigger submenu event
                EkashCore.trigger('submenuToggled', {
                    target: target,
                    expanded: !isExpanded
                });
            }
        },

        // Handle browser navigation
        handleBrowserNavigation: function(event) {
            const newPath = window.location.pathname;
            
            this.setActiveStates(newPath);
            
            // Trigger navigation event
            EkashCore.trigger('navigationChanged', {
                from: state.currentPath,
                to: newPath,
                type: 'popstate'
            });
            
            state.currentPath = newPath;
        },

        // Set active states
        setActiveStates: function(path = null) {
            const currentPath = path || window.location.pathname;
            
            // Clear all active states
            state.menuItems.forEach(item => {
                item.element.classList.remove(config.activeClass);
                item.parent.classList.remove(config.activeClass);
            });
            
            // Find and set active item
            let activeItem = null;
            let bestMatch = '';
            
            state.menuItems.forEach(item => {
                if (currentPath.startsWith(item.href) && item.href.length > bestMatch.length) {
                    bestMatch = item.href;
                    activeItem = item;
                }
            });
            
            if (activeItem) {
                activeItem.element.classList.add(config.activeClass);
                activeItem.parent.classList.add(config.activeClass);
                
                // Expand parent submenu if needed
                if (activeItem.submenu) {
                    const submenu = document.getElementById(activeItem.submenu);
                    if (submenu) {
                        submenu.classList.add(config.collapseClass);
                        
                        // Update toggle icon
                        const toggle = document.querySelector(`[data-bs-target="#${activeItem.submenu}"]`);
                        if (toggle) {
                            const icon = toggle.querySelector('.bi-chevron-down');
                            if (icon) {
                                icon.style.transform = 'rotate(180deg)';
                            }
                        }
                    }
                }
            }
        },

        // Add to navigation history
        addToHistory: function(href, title) {
            if (!config.history.enabled) return;
            
            const entry = {
                href: href,
                title: title,
                timestamp: Date.now()
            };
            
            // Remove duplicate entries
            state.history = state.history.filter(item => item.href !== href);
            
            // Add to beginning
            state.history.unshift(entry);
            
            // Limit history size
            if (state.history.length > config.history.maxEntries) {
                state.history = state.history.slice(0, config.history.maxEntries);
            }
            
            // Store in session storage
            try {
                sessionStorage.setItem('ekash_nav_history', JSON.stringify(state.history));
            } catch (e) {
                console.warn('Failed to store navigation history:', e);
            }
        },

        // Get navigation history
        getHistory: function() {
            return state.history;
        },

        // Load history from storage
        loadHistory: function() {
            try {
                const stored = sessionStorage.getItem('ekash_nav_history');
                if (stored) {
                    state.history = JSON.parse(stored);
                }
            } catch (e) {
                console.warn('Failed to load navigation history:', e);
            }
        }
    };

    // Breadcrumb system
    const breadcrumb = {
        // Generate breadcrumbs
        generate: function(path = null) {
            if (!config.breadcrumb.enabled) return [];
            
            const currentPath = path || window.location.pathname;
            const segments = currentPath.split('/').filter(segment => segment !== '');
            
            const breadcrumbs = [{
                text: 'Ana Sayfa',
                href: '/',
                active: segments.length === 0
            }];
            
            let currentHref = '';
            segments.forEach((segment, index) => {
                currentHref += '/' + segment;
                
                const menuItem = state.menuItems.get(currentHref);
                const text = menuItem ? menuItem.text : this.formatSegment(segment);
                
                breadcrumbs.push({
                    text: text,
                    href: currentHref,
                    active: index === segments.length - 1
                });
            });
            
            state.breadcrumbs = breadcrumbs;
            return breadcrumbs;
        },

        // Format URL segment for display
        formatSegment: function(segment) {
            return segment
                .replace(/-/g, ' ')
                .replace(/\b\w/g, l => l.toUpperCase());
        },

        // Render breadcrumbs
        render: function(container) {
            if (!container) return;
            
            const breadcrumbs = this.generate();
            
            container.innerHTML = breadcrumbs.map(crumb => {
                if (crumb.active) {
                    return `<li class="breadcrumb-item active">${crumb.text}</li>`;
                } else {
                    return `<li class="breadcrumb-item"><a href="${crumb.href}">${crumb.text}</a></li>`;
                }
            }).join('');
        },

        // Auto-update breadcrumbs
        autoUpdate: function() {
            const containers = document.querySelectorAll('.breadcrumb-nav, [data-breadcrumb]');
            containers.forEach(container => {
                this.render(container);
            });
        }
    };

    // Enhanced sidebar system
    const sidebar = {
        // Initialize sidebar
        init: function() {
            this.setupEventListeners();
            this.checkMobile();
            this.setupGestures();
        },

        // Setup event listeners
        setupEventListeners: function() {
            // Window resize
            window.addEventListener('resize', EkashCore.utils.debounce(() => {
                this.checkMobile();
            }, 250));

            // Toggle button
            const toggleBtn = document.querySelector('.sidebar-toggle');
            if (toggleBtn) {
                toggleBtn.addEventListener('click', () => {
                    this.toggle();
                });
            }

            // Overlay click (mobile)
            document.addEventListener('click', (event) => {
                if (state.sidebar.mobile && !state.sidebar.collapsed) {
                    const sidebar = document.querySelector('.sidebar');
                    if (sidebar && !sidebar.contains(event.target) && 
                        !event.target.closest('.sidebar-toggle')) {
                        this.collapse();
                    }
                }
            });

            // Escape key
            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && state.sidebar.mobile && !state.sidebar.collapsed) {
                    this.collapse();
                }
            });
        },

        // Check if mobile
        checkMobile: function() {
            const isMobile = window.innerWidth < 768;
            
            if (isMobile !== state.sidebar.mobile) {
                state.sidebar.mobile = isMobile;
                
                const sidebar = document.querySelector('.sidebar');
                if (sidebar) {
                    if (isMobile) {
                        sidebar.classList.add('sidebar-mobile');
                        this.collapse();
                    } else {
                        sidebar.classList.remove('sidebar-mobile');
                        this.expand();
                    }
                }
            }
        },

        // Toggle sidebar
        toggle: function() {
            if (state.sidebar.collapsed) {
                this.expand();
            } else {
                this.collapse();
            }
        },

        // Expand sidebar
        expand: function() {
            const sidebar = document.querySelector('.sidebar');
            if (!sidebar) return;
            
            state.sidebar.collapsed = false;
            sidebar.classList.remove('sidebar-collapsed');
            
            // Add overlay for mobile
            if (state.sidebar.mobile) {
                this.addOverlay();
            }
            
            // Trigger event
            EkashCore.trigger('sidebarExpanded');
        },

        // Collapse sidebar
        collapse: function() {
            const sidebar = document.querySelector('.sidebar');
            if (!sidebar) return;
            
            state.sidebar.collapsed = true;
            sidebar.classList.add('sidebar-collapsed');
            
            // Remove overlay
            this.removeOverlay();
            
            // Trigger event
            EkashCore.trigger('sidebarCollapsed');
        },

        // Add overlay for mobile
        addOverlay: function() {
            let overlay = document.querySelector('.sidebar-overlay');
            if (!overlay) {
                overlay = document.createElement('div');
                overlay.className = 'sidebar-overlay';
                overlay.addEventListener('click', () => this.collapse());
                document.body.appendChild(overlay);
            }
            
            overlay.classList.add('active');
        },

        // Remove overlay
        removeOverlay: function() {
            const overlay = document.querySelector('.sidebar-overlay');
            if (overlay) {
                overlay.classList.remove('active');
                setTimeout(() => {
                    overlay.remove();
                }, 300);
            }
        },

        // Setup touch gestures
        setupGestures: function() {
            if (!state.sidebar.mobile) return;
            
            let startX = 0;
            let startY = 0;
            let currentX = 0;
            let currentY = 0;
            let isSwipeGesture = false;
            
            document.addEventListener('touchstart', (event) => {
                startX = event.touches[0].clientX;
                startY = event.touches[0].clientY;
                isSwipeGesture = false;
            });
            
            document.addEventListener('touchmove', (event) => {
                currentX = event.touches[0].clientX;
                currentY = event.touches[0].clientY;
                
                const deltaX = currentX - startX;
                const deltaY = Math.abs(currentY - startY);
                
                // Check if horizontal swipe
                if (Math.abs(deltaX) > 10 && deltaY < 100) {
                    isSwipeGesture = true;
                }
            });
            
            document.addEventListener('touchend', () => {
                if (isSwipeGesture) {
                    const deltaX = currentX - startX;
                    
                    // Swipe right to open
                    if (deltaX > 50 && startX < 50 && state.sidebar.collapsed) {
                        this.expand();
                    }
                    // Swipe left to close
                    else if (deltaX < -50 && !state.sidebar.collapsed) {
                        this.collapse();
                    }
                }
            });
        }
    };

    // Search system
    const search = {
        // Initialize search
        init: function() {
            this.setupEventListeners();
            this.buildIndex();
        },

        // Setup event listeners
        setupEventListeners: function() {
            const searchInputs = document.querySelectorAll('.search-input, [data-search]');
            
            searchInputs.forEach(input => {
                input.addEventListener('input', EkashCore.utils.debounce((event) => {
                    this.performSearch(event.target.value);
                }, 300));
            });
        },

        // Build search index
        buildIndex: function() {
            const searchableItems = [];
            
            // Add menu items
            state.menuItems.forEach(item => {
                searchableItems.push({
                    type: 'menu',
                    title: item.text,
                    href: item.href,
                    keywords: item.text.toLowerCase()
                });
            });
            
            // Add other searchable content
            const contentElements = document.querySelectorAll('[data-searchable]');
            contentElements.forEach(element => {
                const title = element.getAttribute('data-search-title') || element.textContent;
                const href = element.getAttribute('data-search-href') || '#';
                const keywords = element.textContent.toLowerCase();
                
                searchableItems.push({
                    type: 'content',
                    title: title,
                    href: href,
                    keywords: keywords
                });
            });
            
            this.index = searchableItems;
        },

        // Perform search
        performSearch: function(query) {
            if (!query || query.length < 2) {
                this.clearResults();
                return;
            }
            
            const results = this.index.filter(item => {
                return item.keywords.includes(query.toLowerCase());
            });
            
            this.displayResults(results, query);
            
            // Trigger search event
            EkashCore.trigger('searchPerformed', {
                query: query,
                results: results
            });
        },

        // Display search results
        displayResults: function(results, query) {
            const container = document.querySelector('.search-results');
            if (!container) return;
            
            if (results.length === 0) {
                container.innerHTML = '<div class="search-no-results">Sonuç bulunamadı</div>';
                return;
            }
            
            container.innerHTML = results.map(result => {
                const highlightedTitle = result.title.replace(
                    new RegExp(`(${query})`, 'gi'),
                    '<mark>$1</mark>'
                );
                
                return `
                    <div class="search-result">
                        <a href="${result.href}" class="search-result-link">
                            <div class="search-result-title">${highlightedTitle}</div>
                            <div class="search-result-type">${result.type}</div>
                        </a>
                    </div>
                `;
            }).join('');
        },

        // Clear search results
        clearResults: function() {
            const container = document.querySelector('.search-results');
            if (container) {
                container.innerHTML = '';
            }
        }
    };

    // Initialize navigation system
    function init() {
        EkashCore.performance.mark('navigation-init-start');
        
        // Load history
        menu.loadHistory();
        
        // Initialize components
        menu.init();
        breadcrumb.autoUpdate();
        sidebar.init();
        search.init();
        
        // Setup page change detection
        let currentUrl = window.location.href;
        const checkForChanges = () => {
            if (window.location.href !== currentUrl) {
                currentUrl = window.location.href;
                breadcrumb.autoUpdate();
                menu.setActiveStates();
            }
        };
        
        // Check for URL changes (for SPA-like behavior)
        setInterval(checkForChanges, 100);
        
        // Debug info
        if (config.debug) {
            console.log('🧭 Ekash Navigation initialized');
        }
        
        EkashCore.performance.mark('navigation-init-end');
        EkashCore.performance.measure('navigation-init', 'navigation-init-start', 'navigation-init-end');
        
        // Trigger ready event
        EkashCore.trigger('navigationReady');
    }

    // Public API
    window.EkashNavigation = {
        // Configuration
        config: config,
        
        // Systems
        menu: menu,
        breadcrumb: breadcrumb,
        sidebar: sidebar,
        search: search,
        
        // Convenience methods
        setActiveStates: menu.setActiveStates.bind(menu),
        toggleSidebar: sidebar.toggle.bind(sidebar),
        generateBreadcrumbs: breadcrumb.generate.bind(breadcrumb),
        performSearch: search.performSearch.bind(search),
        
        // Initialize
        init: init
    };

    // Auto-initialize when core is ready
    EkashCore.on('coreReady', init);

})();