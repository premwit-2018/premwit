importScripts("js/sw-toolbox.js")
importScripts("js/sw-toolbox-cache.js")

toolbox.precache([
  '/offline.html',
  '/node_modules/materialize-css/dist/css/materialize.min.css',
  '/node_modules/tether/dist/css/tether.min.css',
  '/node_modules/jquery/dist/jquery.js',
  '/node_modules/tether/dist/js/tether.min.js',
  'https://fonts.googleapis.com/css?family=Kanit',
  '/node_modules/frontend/style.css',
  '/img/logo.png'
])

toolbox.options.debug = true
toolbox.options.cache.name="premwits-v1";

self.addEventListener("install", function install() {
  self.skipWaiting()
})

self.addEventListener("activate", function activate(e) {
  e.waitUntil(self.clients.claim())
})

toolbox.router.get("/(.*)", function get(req, vals, opts) {
  return toolbox.networkFirst(req, vals, opts)
    .catch(function(error) {
      if (req.method === "GET" && req.headers.get("accept").includes("text/html")) {
        return toolbox.cacheOnly(new Request("/offline.html"), vals, opts)
      }
      throw error
    })
})

toolbox.router.get("/node_modules/materialize-css/dist/css/materialize.min.css", toolbox.cacheFirst)
toolbox.router.get("/node_modules/tether/dist/css/tether.min.css", toolbox.cacheFirst)
toolbox.router.get("/node_modules/jquery/dist/jquery.js", toolbox.cacheFirst)
toolbox.router.get("/node_modules/tether/dist/js/tether.min.js", toolbox.cacheFirst)
toolbox.router.get("https://fonts.googleapis.com/css?family=Kanit", toolbox.cacheFirst)
toolbox.router.get("/node_modules/frontend/style.css", toolbox.cacheFirst)
toolbox.router.get("/img/logo.png", toolbox.cacheFirst)
toolbox.router.get("/manifest.json", toolbox.fastest)