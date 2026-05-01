var CACHE_NAME = 'GZ_APP_SHELL';
var DYNAMIC_CACHE_NAME = 'GZ_DYNAMIC_CACHE';
var urlsToCache = [

];

// cache size limiting

const limitCacheSize = (name, size) => {
    caches.open(name).then(cache => {
        cache.keys().then(keys => {
            if (keys.length > size) {
                console.log(`Limiting cache size......`);
                console.log(`cache length is : ${keys.length}`);
                cache.delete(keys[0]).then(limitCacheSize(name, size))
            }
        })
    })
}


self.addEventListener('install', function (event) {
    // Perform install steps
    self.skipWaiting()
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(function (cache) {
                console.log('Opened cache to store shell assets');
                cache.addAll(urlsToCache);
            })
    );
});

// Listen to activate event

self.addEventListener('activate', e => {
    console.log(`Service worker activated...`);
    e.waitUntil(
        caches.keys().then(keys => {
            return Promise.all(keys
                .filter(key => key !== CACHE_NAME || key !== DYNAMIC_CACHE_NAME)
                .map(key => caches.delete(key))
            )
        })
    )
});

// Listen to fetch event
const cacheableExtensions = ['.js', '.css', '.png', '.jpg', '.jpeg', '.gif', '.svg', '.woff2', '.webp'];
self.addEventListener('fetch', event => {
    const request = event.request;
    const url = new URL(request.url);
    /**Stale while revalidate strategy */
    if (request.method === 'GET' && cacheableExtensions.some((ext) => url.pathname.endsWith(ext) || url.pathname.includes(ext))) {
        console.log(`caching  url ...${url}`);
        event.respondWith(
            caches.open(DYNAMIC_CACHE_NAME)
                .then(function (cache) {
                    console.log(`Getting request from cache .....`);
                    return cache.match(event.request)
                        .then(function (response) {
                            console.log(`Getting request from Network .....`);
                            var fetchPromise = fetch(event.request)
                                .then(function (networkResponse) {
                                    console.log(`Update cache from network response in the background .....`);
                                    cache.put(event.request, networkResponse.clone());
                                    limitCacheSize(DYNAMIC_CACHE_NAME, 1024);
                                    return networkResponse;
                                })
                            return response || fetchPromise;
                        })
                })
        );
    } else {
        console.log(`No route matched those to cache .....${event.request.url}`);
    }

});