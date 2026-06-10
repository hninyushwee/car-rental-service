import * as lucide from 'lucide';

// Initialize Lucide icons when DOM is ready
function initLucideIcons() {
    if (typeof lucide !== 'undefined' && typeof lucide.createIcons === 'function') {
        lucide.createIcons();
    }
}

// Initialize on DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLucideIcons);
} else {
    initLucideIcons();
}

// Reinitialize icons when they're dynamically updated
const observer = new MutationObserver(initLucideIcons);
observer.observe(document.body, { childList: true, subtree: true });

