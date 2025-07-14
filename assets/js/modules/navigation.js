/**
 * Ekash Navigation Module - Menu management, page routing and active state handling
 * @version 1.0.0
 * @requires EkashCore
 */

const EkashNavigation = (function() {
    'use strict';

    // Private variables
    let isInitialized = false;
    const config = {
        activeClass: 'active',
        showClass: 'show',
        menuSelector: '.settings-menu a, .menu a, .nav-link',
        submenuSelector: '#harcamalarSubmenu',
        parentSelector: 'li'
    };

    /**
     * Initialize navigation module
     */
    function init() {
        if (isInitialized) {
            console.warn('EkashNavigation already initialized');
            return;
        }

        console.log('🧭 Ekash Navigation initializing...');

        EkashCore.ready(() => {
            setActiveMenuItem();
            initMenuInteractions();
        });

        isInitialized = true;
        console.log('✅ Ekash Navigation initialized successfully');
    }

    /**
     * Set active menu item based on current URL
     */
    function setActiveMenuItem() {
        const currentLocation = window.location;
        const menuLinks = document.querySelectorAll(config.menuSelector);
        
        // Clear all active states first
        clearActiveStates();
        
        // Find matching menu item
        let activeLink = null;
        let exactMatch = false;
        
        menuLinks.forEach(link => {
            const linkHref = link.getAttribute('href');
            
            if (!linkHref) return;
            
            // Exact match (highest priority)
            if (link.href === currentLocation.href) {
                activeLink = link;
                exactMatch = true;
                return;
            }
            
            // Pathname match (if no exact match found)
            if (!exactMatch && linkHref === currentLocation.pathname) {
                activeLink = link;
            }
            
            // Filename match (fallback)
            if (!exactMatch && !activeLink) {
                const linkFile = linkHref.split('/').pop().split('?')[0];
                const currentFile = currentLocation.pathname.split('/').pop().split('?')[0];
                
                if (linkFile && linkFile === currentFile) {
                    activeLink = link;
                }
            }
        });
        
        // Set active states
        if (activeLink) {
            setActiveState(activeLink);
        }
        
        console.log('✅ Active menu item set:', activeLink?.textContent?.trim());
    }

    /**
     * Clear all active states
     */
    function clearActiveStates() {
        const activeElements = document.querySelectorAll(`.${config.activeClass}`);
        activeElements.forEach(element => {
            element.classList.remove(config.activeClass);
        });
        
        const showElements = document.querySelectorAll(`.${config.showClass}`);
        showElements.forEach(element => {
            element.classList.remove(config.showClass);
        });
    }

    /**
     * Set active state for a menu link and its parents
     */
    function setActiveState(link) {
        if (!link) return;
        
        // Set link as active
        link.classList.add(config.activeClass);
        
        // Traverse up the DOM to set parent states
        let currentElement = link.parentElement;
        
        while (currentElement && currentElement !== document.body) {
            // If this is a list item, mark it as active
            if (currentElement.tagName.toLowerCase() === 'li') {
                currentElement.classList.add(config.activeClass);
                
                // Check if this is part of a submenu
                const parentCollapse = currentElement.closest('.collapse');
                if (parentCollapse) {
                    parentCollapse.classList.add(config.showClass);
                    
                    // Find and update the toggle button
                    const toggleButton = document.querySelector(`[data-bs-target="#${parentCollapse.id}"]`);
                    if (toggleButton) {
                        toggleButton.setAttribute('aria-expanded', 'true');
                        toggleButton.classList.add(config.activeClass);
                    }
                }
            }
            
            currentElement = currentElement.parentElement;
        }
        
        // Trigger event
        EkashCore.triggerEvent('menuItemActivated', { 
            link, 
            text: link.textContent?.trim(),
            href: link.getAttribute('href')
        });
    }

    /**
     * Initialize menu interactions
     */
    function initMenuInteractions() {
        initMenuClicks();
        initBreadcrumbs();
        
        console.log('✅ Menu interactions initialized');
    }

    /**
     * Initialize menu click handlers
     */
    function initMenuClicks() {
        const menuLinks = document.querySelectorAll(config.menuSelector);
        
        menuLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                const href = link.getAttribute('href');
                
                // Skip if it's a toggle link or anchor link
                if (!href || href.startsWith('#') || link.hasAttribute('data-bs-toggle')) {
                    return;
                }
                
                // Update active state immediately for better UX
                clearActiveStates();
                setActiveState(link);
                
                // Trigger navigation event
                EkashCore.triggerEvent('navigationStarted', {
                    link,
                    href,
                    text: link.textContent?.trim()
                });
            });
        });
    }

    /**
     * Initialize breadcrumb system
     */
    function initBreadcrumbs() {
        const breadcrumbContainer = document.querySelector('.breadcrumb');
        if (!breadcrumbContainer) return;
        
        updateBreadcrumbs();
    }

    /**
     * Update breadcrumbs based on current page
     */
    function updateBreadcrumbs() {
        const breadcrumbContainer = document.querySelector('.breadcrumb');
        if (!breadcrumbContainer) return;
        
        const currentPath = window.location.pathname;
        const pathSegments = currentPath.split('/').filter(segment => segment);
        
        // Get page title from active menu item or document title
        const activeLink = document.querySelector(`${config.menuSelector}.${config.activeClass}`);
        const pageTitle = activeLink?.textContent?.trim() || document.title;
        
        // Clear existing breadcrumbs
        breadcrumbContainer.innerHTML = '';
        
        // Add home breadcrumb
        const homeBreadcrumb = createBreadcrumbItem('Ana Sayfa', 'index.php', false);
        breadcrumbContainer.appendChild(homeBreadcrumb);
        
        // Add current page breadcrumb (if not home)
        if (pathSegments.length > 0 && !currentPath.includes('index.php')) {
            const currentBreadcrumb = createBreadcrumbItem(pageTitle, null, true);
            breadcrumbContainer.appendChild(currentBreadcrumb);
        }
    }

    /**
     * Create breadcrumb item
     */
    function createBreadcrumbItem(text, href, isActive) {
        const li = EkashCore.createElement('li', {
            className: `breadcrumb-item${isActive ? ' active' : ''}`
        });
        
        if (href && !isActive) {
            const link = EkashCore.createElement('a', {
                href: href,
                className: 'text-decoration-none'
            }, text);
            li.appendChild(link);
        } else {
            li.textContent = text;
            if (isActive) {
                li.setAttribute('aria-current', 'page');
            }
        }
        
        return li;
    }

    /**
     * Navigate to a specific page
     */
    function navigateTo(href, options = {}) {
        const { replace = false, newTab = false } = options;
        
        if (newTab) {
            window.open(href, '_blank');
            return;
        }
        
        if (replace) {
            window.location.replace(href);
        } else {
            window.location.href = href;
        }
        
        // Trigger event
        EkashCore.triggerEvent('navigationTriggered', { href, options });
    }

    /**
     * Go back in history
     */
    function goBack() {
        if (window.history.length > 1) {
            window.history.back();
        } else {
            navigateTo('index.php');
        }
        
        EkashCore.triggerEvent('navigationBack');
    }

    /**
     * Refresh current page
     */
    function refresh() {
        window.location.reload();
        EkashCore.triggerEvent('navigationRefresh');
    }

    /**
     * Check if current page matches given pattern
     */
    function isCurrentPage(pattern) {
        const currentPath = window.location.pathname.toLowerCase();
        const currentFile = currentPath.split('/').pop();
        
        if (typeof pattern === 'string') {
            return currentPath.includes(pattern.toLowerCase()) || 
                   currentFile === pattern.toLowerCase();
        }
        
        if (pattern instanceof RegExp) {
            return pattern.test(currentPath);
        }
        
        return false;
    }

    /**
     * Get current page information
     */
    function getCurrentPageInfo() {
        const activeLink = document.querySelector(`${config.menuSelector}.${config.activeClass}`);
        
        return {
            path: window.location.pathname,
            href: window.location.href,
            file: window.location.pathname.split('/').pop(),
            title: document.title,
            activeMenuText: activeLink?.textContent?.trim() || null,
            activeMenuHref: activeLink?.getAttribute('href') || null
        };
    }

    /**
     * Highlight menu items matching search term
     */
    function searchMenu(searchTerm) {
        const menuLinks = document.querySelectorAll(config.menuSelector);
        const results = [];
        
        if (!searchTerm || searchTerm.length < 2) {
            // Clear search highlights
            menuLinks.forEach(link => {
                link.classList.remove('search-highlight');
            });
            return results;
        }
        
        const term = searchTerm.toLowerCase();
        
        menuLinks.forEach(link => {
            const text = link.textContent?.trim().toLowerCase();
            
            if (text && text.includes(term)) {
                link.classList.add('search-highlight');
                results.push({
                    element: link,
                    text: link.textContent?.trim(),
                    href: link.getAttribute('href')
                });
            } else {
                link.classList.remove('search-highlight');
            }
        });
        
        EkashCore.triggerEvent('menuSearched', { term: searchTerm, results });
        
        return results;
    }

    /**
     * Add new menu item dynamically
     */
    function addMenuItem(parentSelector, item) {
        const parent = document.querySelector(parentSelector);
        if (!parent) {
            console.warn('Parent menu not found:', parentSelector);
            return null;
        }
        
        const menuItem = EkashCore.createElement('li', {
            className: 'nav-item'
        });
        
        const link = EkashCore.createElement('a', {
            className: 'nav-link',
            href: item.href || '#'
        });
        
        if (item.icon) {
            const icon = EkashCore.createElement('i', {
                className: item.icon
            });
            link.appendChild(icon);
        }
        
        const text = EkashCore.createElement('span', {}, item.text);
        link.appendChild(text);
        
        menuItem.appendChild(link);
        parent.appendChild(menuItem);
        
        // Initialize interactions for new item
        link.addEventListener('click', (e) => {
            if (item.href && item.href !== '#') {
                clearActiveStates();
                setActiveState(link);
            }
        });
        
        EkashCore.triggerEvent('menuItemAdded', { item, element: menuItem });
        
        return menuItem;
    }

    /**
     * Remove menu item
     */
    function removeMenuItem(selector) {
        const menuItem = document.querySelector(selector);
        if (menuItem) {
            menuItem.remove();
            EkashCore.triggerEvent('menuItemRemoved', { selector });
            return true;
        }
        return false;
    }

    /**
     * Public API
     */
    return {
        // Initialization
        init,
        
        // Active state management
        setActiveMenuItem,
        setActiveState,
        clearActiveStates,
        
        // Navigation
        navigateTo,
        goBack,
        refresh,
        
        // Page information
        isCurrentPage,
        getCurrentPageInfo,
        
        // Breadcrumbs
        updateBreadcrumbs,
        
        // Menu management
        searchMenu,
        addMenuItem,
        removeMenuItem,
        
        // Config access
        config
    };
})();

// Auto-initialize when core is ready
EkashCore.ready(() => {
    EkashNavigation.init();
});

// Make navigation functions globally available
window.navigateTo = EkashNavigation.navigateTo;
window.goBack = EkashNavigation.goBack;

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = EkashNavigation;
}

// Global namespace
window.EkashNavigation = EkashNavigation;