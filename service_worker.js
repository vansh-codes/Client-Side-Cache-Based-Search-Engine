const CACHE_NAME = "client-cache-v1";
const urlsToCache = [
    "/",
    "/styles.css",
    "/index.php",
    "/results.php"
];

// Install the service worker and cache all specified files
self.addEventListener("install", (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then(async (cache) => {
            try {
                const response = await fetch('./cache-files.php');
                const cacheFiles = await response.json();

                // Ensure cacheFiles is an array before caching
                if (Array.isArray(cacheFiles)) {
                    await cache.addAll(cacheFiles);
                    console.log('Files cached successfully');
                } else {
                    console.error('Cache files is not an array');
                }
            } catch (error) {
                console.error('Failed to cache files', error);
            }
        })
    );
});

self.addEventListener("activate", (evt) => {
    evt.waitUntil(
        caches.keys().then((keys) => {
            return Promise.all(
                keys
                    .filter((key) => key !== CACHE_NAME)
                    .map((key) => caches.delete(key))
            );
        })
    );
    self.clients.claim();
});

// Fetch event to serve cached files when offline
self.addEventListener("fetch", (event) => {
    event.respondWith(
        caches
            .match(event.request)
            .then((response) => response || fetch(event.request))
            .catch(() => caches.match("/"))
    );
});
