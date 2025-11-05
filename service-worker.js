const CACHE_NAME = "dashboard-cache-v1";
const urlsToCache = [
  "/PDT0/",
  "/PDT0/manifest.json",
  "/PDT0/app/systems/filemanager/favicons/favicon-32x32.png",
  "/PDT0/app/systems/filemanager/favicons/favicon-16x16.png",
  "https://cdn.tailwindcss.com",
  "https://unpkg.com/lucide@latest"
];

// Install service worker & cache files
self.addEventListener("install", (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => cache.addAll(urlsToCache))
  );
});

// Fetch requests
self.addEventListener("fetch", (event) => {
  event.respondWith(
    caches.match(event.request).then((resp) => {
      return resp || fetch(event.request);
    })
  );
});

// Update cache on new version
self.addEventListener("activate", (event) => {
  event.waitUntil(
    caches.keys().then((names) =>
      Promise.all(
        names.filter((name) => name !== CACHE_NAME).map((n) => caches.delete(n))
      )
    )
  );
});
