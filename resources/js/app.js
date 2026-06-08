import './bootstrap'
import '../css/app.css';
import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'

import App from './App.vue'
import Home from './components/user/Home.vue'


// Create router
const routes = [
  {
    path: '/',
    name: 'home',
    component: Home
  },
  {
    path: '/:pathMatch(.*)*',
    name: 'NotFound',
    component: () => import('./pages/NotFound.vue')
  }
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition
    } else {
      return { top: 0 }
    }
  }
})

const app = createApp(App)
createInertiaApp({
    title: (title) => `${title} - SkyLine`,
    // Automatically find and resolve Vue files inside resources/js/Pages/
    resolve: (name) => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
        return pages[`./Pages/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el);
    },
    progress: {
        // Adds a clean loading bar at the top of the viewport during page swaps
        color: '#22d3ee', // Cyan color matching your theme
    },
});

// Use router
app.use(router)

// Mount app
app.mount('#app')
