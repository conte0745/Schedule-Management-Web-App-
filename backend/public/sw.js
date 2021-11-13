var urlsToCache = [
    '/js/app.js'
];

self.addEventListener('install', function (event) {
    return install(event);
});

self.addEventListener('message', function (event) {
    return install(event);
});

const install = (event) => {
    return event.waitUntil(
        caches.open('laboCache')
        .then(function (cache) {
            urlsToCache.map(url => {
                return fetch(new Request(url)).then(response => {
                    return cache.put(url, response);
                });
            })
        })
        .catch(function (err) {
            console.log(err);
        })
    );
}

self.addEventListener('activate', function (e) {
    console.log('ServiceWorker activate')
})

self.addEventListener('fetch', function (event) {})