import jQuery from 'jquery';

window.$ = window.jQuery = jQuery;

// Inject legacy patches required by older plugins
window.$.camelCase = function(str) {
    return str.replace(/-([a-z])/g, function(g) { return g[1].toUpperCase(); });
};

window.$.type = function(obj) {
    if (obj == null) return obj + "";
    return typeof obj === "object" || typeof obj === "function"
        ? Object.prototype.toString.call(obj).replace(/^\[object\s|\]$/g, '').toLowerCase()
        : typeof obj;
};