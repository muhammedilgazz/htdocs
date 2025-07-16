/**
 * Service Worker for Budget Management System
 * Modern PWA features with offline support
 */

const CACHE_NAME = 'budget-app-v1.0.0';
const OFFLINE_URL = '/offline.html';

// Assets to cache immediately
const CORE_ASSETS = [
    '/',
    '/offline.html',
    '/assets/css/modern-enhanced.css',
    '/assets/css/components-enhanced.css',
    '/assets/css/ekash-minimal.css',
    '/assets/css/custom-colors.css',
    '/assets/js/modules/core.js',
    '/assets/js/modules/ui.js',
    '/assets/js/modules/forms.js',
    '/assets/js/modules/navigation.js',
    '/assets/js/scripts.js',
    '/assets/images/logo.png',
    '/assets/images/favicon.png',
    'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap',
    'https://fonts.googleapis.com/icon?family=Material+Icons+Round',
    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css',
    'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css'
];

// Install event - cache core assets
self.addEventListener('install', (event) => {
    console.log('🔧 Service Worker installing...');
    
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then((cache) => {
                console.log('📦 Caching core assets...');
                return cache.addAll(CORE_ASSETS);
            })
            .then(() => {
                console.log('✅ Core assets cached successfully');
                return self.skipWaiting();
            })
            .catch((error) => {
                console.error('❌ Failed to cache core assets:', error);
            })
    );
});

// Activate event - clean up old caches
self.addEventListener('activate', (event) => {
    console.log('🚀 Service Worker activating...');
    
    event.waitUntil(
        caches.keys()
            .then((cacheNames) => {
                return Promise.all(
                    cacheNames.map((cacheName) => {
                        if (cacheName !== CACHE_NAME) {
                            console.log('🗑️ Deleting old cache:', cacheName);
                            return caches.delete(cacheName);
                        }
                    })
                );
            })
            .then(() => {
                console.log('✅ Service Worker activated');
                return self.clients.claim();
            })
    );
});

// Fetch event - serve from cache or network
self.addEventListener('fetch', (event) => {
    // Skip non-GET requests
    if (event.request.method !== 'GET') {
        return;
    }
    
    // Skip chrome-extension requests
    if (event.request.url.startsWith('chrome-extension://')) {
        return;
    }
    
    // Handle navigation requests
    if (event.request.mode === 'navigate') {
        event.respondWith(
            fetch(event.request)
                .catch(() => {
                    return caches.match(OFFLINE_URL);
                })
        );
        return;
    }
    
    // Handle other requests with cache-first strategy
    event.respondWith(
        caches.match(event.request)
            .then((cachedResponse) => {
                if (cachedResponse) {
                    // Serve from cache
                    return cachedResponse;
                }
                
                // Fetch from network and cache
                return fetch(event.request)
                    .then((networkResponse) => {
                        // Don't cache non-successful responses
                        if (!networkResponse || networkResponse.status !== 200 || networkResponse.type !== 'basic') {
                            return networkResponse;
                        }
                        
                        // Cache successful responses
                        const responseClone = networkResponse.clone();
                        caches.open(CACHE_NAME)
                            .then((cache) => {
                                cache.put(event.request, responseClone);
                            });
                        
                        return networkResponse;
                    })
                    .catch(() => {
                        // Return offline page for navigation requests
                        if (event.request.destination === 'document') {
                            return caches.match(OFFLINE_URL);
                        }
                        
                        // Return a simple offline response for other requests
                        return new Response('Offline', {
                            status: 503,
                            statusText: 'Service Unavailable',
                            headers: {
                                'Content-Type': 'text/plain'
                            }
                        });
                    });
            })
    );
});

// Background sync for offline actions
self.addEventListener('sync', (event) => {
    console.log('🔄 Background sync triggered:', event.tag);
    
    if (event.tag === 'sync-expenses') {
        event.waitUntil(syncExpenses());
    }
    
    if (event.tag === 'sync-wishlist') {
        event.waitUntil(syncWishlist());
    }
});

// Push notifications
self.addEventListener('push', (event) => {
    console.log('📱 Push notification received');
    
    const options = {
        body: event.data ? event.data.text() : 'Yeni bildirim',
        icon: '/assets/images/icons/icon-192x192.png',
        badge: '/assets/images/icons/badge-72x72.png',
        vibrate: [100, 50, 100],
        data: {
            dateOfArrival: Date.now(),
            primaryKey: 1
        },
        actions: [
            {
                action: 'view',
                title: 'Görüntüle',
                icon: '/assets/images/icons/view-icon.png'
            },
            {
                action: 'dismiss',
                title: 'Kapat',
                icon: '/assets/images/icons/close-icon.png'
            }
        ]
    };
    
    event.waitUntil(
        self.registration.showNotification('Bütçe Yönetimi', options)
    );
});

// Notification click handler
self.addEventListener('notificationclick', (event) => {
    console.log('🔔 Notification clicked:', event.action);
    
    event.notification.close();
    
    if (event.action === 'view') {
        event.waitUntil(
            clients.openWindow('/')
        );
    }
});

// Utility functions
async function syncExpenses() {
    try {
        const offlineExpenses = await getOfflineData('expenses');
        
        for (const expense of offlineExpenses) {
            await fetch('/ajax/add_expense.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(expense)
            });
        }
        
        await clearOfflineData('expenses');
        console.log('✅ Expenses synced successfully');
    } catch (error) {
        console.error('❌ Failed to sync expenses:', error);
    }
}

async function syncWishlist() {
    try {
        const offlineWishlist = await getOfflineData('wishlist');
        
        for (const item of offlineWishlist) {
            await fetch('/ajax/add_wishlist_item.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(item)
            });
        }
        
        await clearOfflineData('wishlist');
        console.log('✅ Wishlist synced successfully');
    } catch (error) {
        console.error('❌ Failed to sync wishlist:', error);
    }
}

async function getOfflineData(type) {
    return new Promise((resolve) => {
        // This would typically interact with IndexedDB
        // For now, return empty array
        resolve([]);
    });
}

async function clearOfflineData(type) {
    return new Promise((resolve) => {
        // This would typically clear IndexedDB data
        // For now, just resolve
        resolve();
    });
}

// Performance monitoring
self.addEventListener('message', (event) => {
    if (event.data && event.data.type === 'PERFORMANCE_MEASURE') {
        console.log('📊 Performance measure:', event.data.data);
    }
});

// Error handling
self.addEventListener('error', (event) => {
    console.error('❌ Service Worker error:', event.error);
});

self.addEventListener('unhandledrejection', (event) => {
    console.error('❌ Unhandled promise rejection in SW:', event.reason);
});

console.log('🚀 Service Worker loaded successfully');