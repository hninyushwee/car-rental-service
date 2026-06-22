import * as lucide from 'lucide';
import { Datepicker } from 'vanillajs-datepicker';
import 'vanillajs-datepicker/css/datepicker.css';
window.Datepicker = Datepicker;
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
