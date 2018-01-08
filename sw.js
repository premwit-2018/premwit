var EXTRA_FILES = [];

var CHECKSUM = "v1";

var FILES = [
  '/offline.html',
  '/node_modules/materialize-css/dist/css/materialize.min.css',
  '/node_modules/tether/dist/css/tether.min.css',
  '/node_modules/jquery/dist/jquery.js',
  '/node_modules/tether/dist/js/tether.min.js',
  'https://fonts.googleapis.com/css?family=Kanit',
  'node_modules/frontend/style.css'
].concat(EXTRA_FILES || []);

var CACHENAME = 'premwits-' + CHECKSUM;

self.addEventListener('install', function(event) {
  event.waitUntil(caches.open(CACHENAME).then(function(cache) {
    return cache.addAll(FILES);
  }));
});

self.addEventListener('activate', function(event) {
  return event.waitUntil(caches.keys().then(function(keys) {
    return Promise.all(keys.map(function(k) {
      if (k != CACHENAME && k.indexOf('premwits-') == 0) {
        return caches.delete(k);
      } else {
        return Promise.resolve();
      }
    }));
  }));
});

self.addEventListener('fetch', event => {
  event.respondWith(
    caches.match(event.request)
      .then(response=>response||fetch(event.request))
      .catch(() => {
        if(event.request.mode == 'navigate') {
          return caches.match('/offline.html');
        }
      })
  );
});
