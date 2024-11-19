// service-worker.js

const CACHE_NAME = "cachemanager-v1";
const FILES_TO_CACHE = [
    "/",
    "/index.php",
    "/add_note.php",
    "/assets/css/style.css",
    "/assets/js/main.js",
    "/templates/header.php",
    "/templates/footer.php",
    "/offline.html",
    // Add other assets to be cached here
];

// Install event: Cache static assets
self.addEventListener("install", (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            console.log("Caching static files...");
            return cache.addAll(FILES_TO_CACHE).catch((err) => {
                console.error("Failed to add files to cache: ", err);
            });
        })
    );
});

// Activate event: Clean up old caches
self.addEventListener("activate", (event) => {
    const cacheWhitelist = [CACHE_NAME];
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cacheName) => {
                    if (!cacheWhitelist.includes(cacheName)) {
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
});

// Fetch event: Handle network requests and serve cached assets
self.addEventListener("fetch", (event) => {
    event.respondWith(
        caches.match(event.request).then((cachedResponse) => {
            // Check if the cached response exists and return it
            if (cachedResponse) {
                return cachedResponse;
            }

            // If it's a request for a PHP page, serve fallback when offline
            if (
                event.request.url.includes("add_note.php") ||
                event.request.url.includes("index.php")
            ) {
                // Only handle PHP requests if they are not cached
                return fetch(event.request)
                    .then((response) => {
                        return caches.open(CACHE_NAME).then((cache) => {
                            cache.put(event.request, response.clone()); // Cache the response for future use
                            return response; // Return the network response
                        });
                    })
                    .catch((error) => {
                        console.error("Error fetching:", error);
                        return caches.match("./offline.html"); // Return offline page when error occurs
                    });
            }

            // Handle other static requests (like CSS, JS)
            return fetch(event.request).catch((error) => {
                console.error(
                    "Network fetch failed, serving offline page:",
                    error
                );
                return caches.match("./offline.html"); // Return offline page in case of failure
            });
        })
    );
});

// Cache search results separately in IndexedDB (optional for advanced caching)
