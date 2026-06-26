import * as lucide from 'lucide';

export function refreshIcons() {
    if (typeof lucide.createIcons === 'function') {
        lucide.createIcons();
    }
}

export { lucide };
