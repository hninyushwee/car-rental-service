import { createIcons, icons } from 'lucide';

createIcons({ icons });

tailwind.config = {
    theme: {
    extend: {
        fontFamily: {
        sans: ["Inter", "ui-sans-serif", "system-ui", "Segoe UI", "sans-serif"]
        },
        boxShadow: {
        glow: "0 24px 80px rgba(8, 145, 178, 0.25)"
        }
    }
    }
};