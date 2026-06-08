<template>
  <div id="app" class="min-h-screen">
    <!-- Navigation Header -->
    <Navigation @toggle-sidebar="toggleSidebar" @open-signin="openSignIn" @open-register="openRegister" />
    
    <!-- Sidebar (Authenticated Users) -->
    <Sidebar v-if="isAuthenticated" :collapsed="sidebarCollapsed" @toggle="toggleSidebar" />
    
    <!-- Main Content -->
    <main id="mainContent" class="transition-all duration-300" :class="mainContentClasses">
      <router-view />
      <slot></slot>
    </main>
    
    <!-- Footer (Optional) -->
    <Footer v-if="!hideFooter" />
    
    <!-- Demo Auth Toggle Button -->
    <button id="authToggle" type="button" @click="toggleAuthState"
      class="fixed bottom-4 right-4 z-50 max-w-[calc(100vw-2rem)] rounded bg-cyan-400 px-4 py-3 text-xs font-black text-slate-950 shadow-2xl shadow-cyan-950/30 transition hover:bg-cyan-300">
      Switch Auth State: {{ isAuthenticated ? 'Logged In' : 'Guest' }}
    </button>

    <!-- Modals (SignIn/Register) -->
    <SignInModal v-if="showSignIn" @close="showSignIn = false" />
    <RegisterModal v-if="showRegister" @close="showRegister = false" />
  </div>
</template>

<script>
import Navigation from '@/components/shared/Navigation.vue'
import Sidebar from '@/components/shared/Sidebar.vue'
import Footer from '@/components/shared/Footer.vue'
import SignInModal from '@/components/modals/SignInModal.vue'
import RegisterModal from '@/components/modals/RegisterModal.vue'

export default {
  name: 'App',
  components: {
    Navigation,
    Sidebar,
    Footer,
    SignInModal,
    RegisterModal
  },
  data() {
    return {
      isAuthenticated: false,
      sidebarCollapsed: false,
      hideFooter: false,
      showSignIn: false,
      showRegister: false,
      lastScrollY: 0
    }
  },
  computed: {
    mainContentClasses() {
      if (!this.isAuthenticated) {
        return ''
      }
      
      // Authenticated state with sidebar
      const baseClass = 'lg:pl-60 pl-16 md:pl-20'
      if (this.sidebarCollapsed) {
        return 'lg:pl-20 pl-16'
      }
      return baseClass
    }
  },
  methods: {
    toggleSidebar() {
      this.sidebarCollapsed = !this.sidebarCollapsed
    },
    toggleAuthState() {
      this.isAuthenticated = !this.isAuthenticated
      this.updateHeaderStyle()
      this.closeMobileMenu()
      
      if (this.isAuthenticated) {
        this.adjustSidebar()
      }
    },
    openSignIn() {
      this.showSignIn = true
    },
    openRegister() {
      this.showRegister = true
    },
    updateHeaderStyle() {
      const header = document.getElementById('siteHeader')
      if (!header) return

      if (this.isAuthenticated) {
        header.classList.add('bg-white/95', 'backdrop-blur', 'shadow-lg')
      } else {
        header.classList.remove('bg-white/95', 'backdrop-blur', 'shadow-lg')
      }
    },
    adjustSidebar() {
      if (window.innerWidth < 768 && !this.sidebarCollapsed) {
        this.sidebarCollapsed = true
      }
    },
    closeMobileMenu() {
      const mobileMenu = document.getElementById('mobileMenu')
      if (mobileMenu) {
        mobileMenu.classList.add('hidden')
      }
    },
    handleScroll() {
      this.lastScrollY = window.scrollY
      
      if (this.isAuthenticated) {
        const header = document.getElementById('siteHeader')
        if (header) {
          if (window.scrollY > 0) {
            header.classList.add('static')
            this.closeMobileMenu()
          } else {
            header.classList.remove('static')
          }
        }
      }
    },
    handleResize() {
      if (this.isAuthenticated && window.innerWidth < 768 && !this.sidebarCollapsed) {
        this.sidebarCollapsed = true
      }
    },
    initializeLucideIcons() {
      // Initialize Lucide icons if library is available
      if (typeof lucide !== 'undefined' && typeof lucide.createIcons === 'function') {
        lucide.createIcons()
      }
    }
  },
  mounted() {
    // Check authentication status from localStorage or API
    // const authToken = localStorage.getItem('authToken')
    // this.isAuthenticated = !!authToken

    window.addEventListener('scroll', this.handleScroll, { passive: true })
    window.addEventListener('resize', this.handleResize)
    this.initializeLucideIcons()
    
    // Re-initialize icons when route changes
    this.$router?.beforeEach(() => {
      this.$nextTick(() => {
        this.initializeLucideIcons()
      })
    })
  },
  beforeUnmount() {
    window.removeEventListener('scroll', this.handleScroll)
    window.removeEventListener('resize', this.handleResize)
  }
}
</script>

<style scoped>
/* Smooth transitions for sidebar and main content */
#mainContent {
  transition-property: padding-left;
  transition-duration: 300ms;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

/* Prevent horizontal overflow on mobile */
body {
  overflow-x: hidden;
}
</style>

<style>
/* Global styles for layout */
html {
  scroll-behavior: smooth;
}

/* Ensure auth UI never wraps on any screen */
[data-auth-ui] {
  flex-wrap: nowrap !important;
  white-space: nowrap !important;
}

/* Prevent entire navigation flex parent from dropping down items */
#siteHeader nav {
  flex-wrap: nowrap !important;
}

/* For very small screens, reduce gap */
@media (max-width: 640px) {
  [data-auth-ui] {
    gap: 0.5rem !important;
  }

  #siteHeader nav {
    gap: 0.35rem !important;
    padding-left: 0.5rem !important;
    padding-right: 0.5rem !important;
  }
}
</style>
