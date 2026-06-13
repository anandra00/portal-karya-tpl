const CACHE_NAME = 'tpl-ipb-cache-v2';
const urlsToCache = [
    '/css/global-ui.css',
    '/images/logotpl.png',
    '/images/pwa_icon.png',
    '/manifest.json'
];

self.addEventListener('install', event => {
    self.skipWaiting();
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => {
                return cache.addAll(urlsToCache);
            })
    );
});

self.addEventListener('fetch', event => {
    const url = new URL(event.request.url);

    // Never cache HTML pages (they contain CSRF tokens that expire)
    // Only cache static assets like CSS, JS, images, fonts
    const isStaticAsset = /\.(css|js|png|jpg|jpeg|gif|svg|ico|woff2?|ttf|eot|webp|json)$/i.test(url.pathname);

    if (event.request.method !== 'GET' || !isStaticAsset) {
        // For HTML pages and non-GET requests, always go to the network
        return;
    }

    event.respondWith(
        caches.match(event.request)
            .then(response => {
                if (response) {
                    return response;
                }
                return fetch(event.request).then(function(response) {
                    if (!response || response.status !== 200 || response.type !== 'basic') {
                        return response;
                    }

                    var responseToCache = response.clone();

                    caches.open(CACHE_NAME)
                        .then(function(cache) {
                            cache.put(event.request, responseToCache);
                        });

                    return response;
                });
            })
    );
});

self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cacheName => {
                    if (cacheName !== CACHE_NAME) {
                        return caches.delete(cacheName);
                    }
                })
            );
        }).then(() => {
            return self.clients.claim();
        })
    );
});
