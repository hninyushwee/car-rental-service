<template>
  <header id="siteHeader" class="fixed inset-x-0 top-0 z-50 transition-all">
    <nav
      class="mx-auto flex max-w-7xl items-center justify-between gap-2 px-3 py-3 sm:gap-3 sm:px-4 md:px-5 md:gap-4 lg:px-6 flex-nowrap overflow-visible">
      
      <!-- Logo Section -->
      <div id="logo" class="flex shrink-0 items-center gap-1 sm:gap-2 md:gap-3">
        <router-link to="/" class="flex shrink-0 items-center gap-1 sm:gap-2 flex-nowrap"
          aria-label="SKY Line home">
          <img class="h-8 w-auto object-contain sm:h-10 md:h-12" :src="logo"
            alt="SkyLine Automotive logo" />
          <p class="bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 bg-clip-text text-transparent font-black text-xl sm:text-2xl md:text-3xl tracking-wide drop-shadow-md whitespace-nowrap">
            SkyLine
          </p>
        </router-link>
      </div>

      <!-- Sidebar Toggle (Mobile/Auth) -->
      <div v-if="isAuthenticated" class="hidden transition-all duration-300 py-1 shrink-0">
        <button type="button" @click="toggleSidebar"
          class="flex h-8 w-8 shrink-0 items-center justify-center rounded border border-slate-300 bg-white/80 text-slate-700 transition hover:border-slate-500 hover:bg-slate-100 hover:text-slate-900">
          <i data-lucide="panel-left" class="h-4 w-4 sm:h-5 sm:w-5"></i>
        </button>
      </div>

      <!-- Desktop Navigation Links -->
      <div class="hidden items-center gap-4 md:flex lg:gap-8 shrink-0 flex-nowrap">
        <router-link to="/" class="text-sm font-semibold transition hover:text-cyan-600 whitespace-nowrap"
          data-nav-contrast>Home</router-link>
        <router-link to="/about" class="text-sm font-semibold transition hover:text-cyan-600 whitespace-nowrap"
          data-nav-contrast>About Us</router-link>
        <router-link to="/contact"
          class="text-sm font-semibold transition hover:text-cyan-600 whitespace-nowrap" data-nav-contrast>Contact Us</router-link>
      </div>

      <!-- Desktop Auth Section -->
      <div class="hidden md:block shrink-0">
        <!-- Guest UI -->
        <div v-if="!isAuthenticated" class="flex items-center gap-2 sm:gap-3 flex-nowrap">
          <button type="button" @click="openSignIn"
            class="rounded border px-3 py-1.5 text-xs font-semibold transition sm:px-4 sm:py-2 sm:text-sm whitespace-nowrap"
            data-nav-contrast-button>Sign In</button>
          <button type="button" @click="openRegister"
            class="rounded bg-cyan-400 px-3 py-1.5 text-xs font-bold text-slate-950 shadow-md transition hover:bg-cyan-700 sm:px-4 sm:py-2 sm:text-sm whitespace-nowrap">Register</button>
        </div>

        <!-- Authenticated UI -->
        <div v-else class="flex flex-row flex-nowrap items-center gap-2 sm:gap-3">
          <!-- Notifications Button -->
          <div class="relative shrink-0">
            <button id="notificationButton" type="button" @click="toggleNotifications"
              class="relative flex h-8 w-8 shrink-0 items-center justify-center rounded border border-slate-300 bg-white/80 text-slate-700 transition hover:border-slate-500 hover:bg-slate-100">
              <i data-lucide="bell" class="h-4 w-4 sm:h-5 sm:w-5"></i>
              <span
                class="absolute right-1.5 top-1.5 h-2 w-2 rounded-full border border-white bg-cyan-600 sm:right-2 sm:top-2 sm:h-2.5 sm:w-2.5"></span>
            </button>
            <!-- Notifications Dropdown -->
            <div v-if="showNotifications" id="notificationDropdown"
              class="absolute right-0 z-[9999] mt-3 w-80 overflow-hidden rounded border border-slate-200 bg-white shadow-2xl">
              <div class="border-b border-slate-100 px-3 py-2 sm:px-4 sm:py-3">
                <p class="text-xs sm:text-sm font-bold text-slate-950">Notifications</p>
                <p class="text-xs text-slate-500">Latest portal activity</p>
              </div>
              <div class="max-h-96 divide-y divide-slate-100 overflow-auto">
                <article v-for="notification in notifications" :key="notification.id" 
                  class="border-l-4 border-cyan-600 bg-cyan-50 px-3 py-2 sm:px-4 sm:py-3">
                  <p class="text-xs sm:text-sm font-semibold text-slate-950">{{ notification.title }}</p>
                  <p class="mt-1 text-xs text-slate-600">{{ notification.message }}</p>
                </article>
              </div>
            </div>
          </div>

          <!-- Profile Button -->
          <div class="relative shrink-0">
            <button id="profileButton" type="button" @click="toggleProfile"
              class="flex items-center gap-1 rounded border border-slate-300 bg-white/80 p-1 pr-2 text-slate-700 transition hover:border-slate-500 hover:bg-slate-100 hover:text-slate-900">
              <img class="h-6 w-6 rounded object-cover sm:h-7 sm:w-7 md:h-8 md:w-8 shrink-0"
                :src="userAvatar"
                alt="User avatar" />
              <i data-lucide="chevron-down" class="h-3 w-3 sm:h-4 sm:w-4 shrink-0"></i>
            </button>
            <!-- Profile Dropdown -->
            <div v-if="showProfile" id="profileDropdown"
              class="absolute right-0 z-[9999] mt-3 w-72 overflow-hidden rounded border border-slate-200 bg-white shadow-2xl">
              <div
                class="flex items-center gap-2 border-b border-slate-100 px-3 py-3 sm:gap-3 sm:px-4 sm:py-4 flex-nowrap">
                <img class="h-8 w-8 rounded object-cover sm:h-10 sm:w-10 md:h-12 md:w-12 shrink-0"
                  :src="userAvatar"
                  :alt="`${userName} profile`" />
                <div class="min-w-0">
                  <p class="text-xs sm:text-sm font-bold text-slate-950 truncate max-w-[140px]">{{ userName }}</p>
                  <p class="text-xs text-slate-500 truncate max-w-[140px]">{{ userEmail }}</p>
                </div>
              </div>
              <div class="p-1 sm:p-2">
                <router-link to="/profile"
                  class="flex items-center gap-2 rounded px-2 py-1.5 text-xs sm:text-sm font-medium text-slate-700 hover:bg-slate-100 sm:gap-3 sm:px-3 sm:py-2 whitespace-nowrap">
                  <i data-lucide="user" class="h-3 w-3 sm:h-4 sm:w-4"></i>My Profile</router-link>
                <router-link to="/settings"
                  class="flex items-center gap-2 rounded px-2 py-1.5 text-xs sm:text-sm font-medium text-slate-700 hover:bg-slate-100 sm:gap-3 sm:px-3 sm:py-2 whitespace-nowrap">
                  <i data-lucide="settings" class="h-3 w-3 sm:h-4 sm:w-4"></i>Account Settings</router-link>
                <router-link to="/bookings"
                  class="flex items-center gap-2 rounded px-2 py-1.5 text-xs sm:text-sm font-medium text-slate-700 hover:bg-slate-100 sm:gap-3 sm:px-3 sm:py-2 whitespace-nowrap">
                  <i data-lucide="calendar-check" class="h-3 w-3 sm:h-4 sm:w-4"></i>Booking History</router-link>
                <button type="button" @click="logout"
                  class="flex w-full items-center gap-2 rounded px-2 py-1.5 text-left text-xs sm:text-sm font-medium text-rose-600 hover:bg-rose-50 sm:gap-3 sm:px-3 sm:py-2 whitespace-nowrap">
                  <i data-lucide="log-out" class="h-3 w-3 sm:h-4 sm:w-4"></i>Logout</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Mobile Menu Button -->
      <button id="mobileMenuButton" type="button" @click="toggleMobileMenu"
        class="grid h-8 w-8 place-items-center rounded border border-slate-300 text-slate-700 sm:h-9 sm:w-9 md:hidden shrink-0"
        data-nav-contrast-button>
        <i data-lucide="menu" class="h-4 w-4 sm:h-5 sm:w-5"></i>
      </button>
    </nav>

    <!-- Mobile Menu -->
    <div v-if="showMobileMenu" id="mobileMenu"
      class="absolute right-3 mt-2 w-64 rounded-xl border border-slate-200 bg-white/95 p-3 shadow-2xl backdrop-blur md:hidden"
      style="z-index: 60; top: 60px;">
      
      <!-- Mobile Navigation Links -->
      <div class="grid gap-2" id="mobileNavLinks">
        <router-link to="/"
          class="rounded px-3 py-2 text-sm font-semibold text-slate-800 hover:bg-slate-100"
          @click="showMobileMenu = false">Home</router-link>
        <router-link to="/about"
          class="rounded px-3 py-2 text-sm font-semibold text-slate-800 hover:bg-slate-100" 
          @click="showMobileMenu = false">About Us</router-link>
        <router-link to="/contact"
          class="rounded px-3 py-2 text-sm font-semibold text-slate-800 hover:bg-slate-100"
          @click="showMobileMenu = false">Contact Us</router-link>
      </div>

      <!-- Mobile Guest UI -->
      <div v-if="!isAuthenticated" class="mt-3 border-t border-slate-200 pt-3">
        <div class="grid grid-cols-2 gap-2">
          <button type="button" @click="openSignIn"
            class="rounded border border-slate-300 px-3 py-1.5 text-xs font-semibold text-slate-700">Sign In</button>
          <button type="button" @click="openRegister"
            class="rounded bg-cyan-400 px-3 py-1.5 text-xs font-bold text-slate-950">Register</button>
        </div>
      </div>

      <!-- Mobile Authenticated UI -->
      <div v-else class="mt-3 border-t border-slate-200 pt-3">
        <div class="space-y-2">
          <button id="mobileNotificationBtn" @click="toggleNotifications"
            class="flex w-full items-center justify-between rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700">
            <span class="flex items-center gap-2"><i data-lucide="bell" class="h-4 w-4"></i>
              Notifications</span>
            <span class="rounded-full bg-cyan-100 px-2 py-0.5 text-xs text-cyan-700">{{ notifications.length }}</span>
          </button>
          <router-link to="/profile"
            class="flex w-full items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700"
            @click="showMobileMenu = false">
            <i data-lucide="user" class="h-4 w-4"></i> My Profile
          </router-link>
          <button id="mobileLogoutBtn" @click="logout"
            class="flex w-full items-center gap-2 rounded-lg border border-rose-200 bg-white px-3 py-2 text-sm font-medium text-rose-600">
            <i data-lucide="log-out" class="h-4 w-4"></i> Logout
          </button>
        </div>
      </div>
    </div>
  </header>
</template>

<script>
import logo from '../assets/images/logo.png'
export default {
  name: 'Navigation',
  data() {
    return {
      isAuthenticated: false,
      showNotifications: false,
      showProfile: false,
      showMobileMenu: false,
      userName: 'Ava Thompson',
      userEmail: 'ava@skyline.demo',
      userAvatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=160&q=80',
      notifications: [
        {
          id: 1,
          title: 'New Booking',
          message: 'A Lexus RX booking request is waiting for review.'
        },
        {
          id: 2,
          title: 'Payment Received',
          message: 'Invoice #SL-2048 was paid successfully.'
        },
        {
          id: 3,
          title: 'Driver Assigned',
          message: 'Marcus Lee has been assigned to tomorrow\'s airport transfer.'
        }
      ]
    }
  },
  methods: {
    toggleNotifications() {
      this.showNotifications = !this.showNotifications;
      this.showProfile = false;
    },
    toggleProfile() {
      this.showProfile = !this.showProfile;
      this.showNotifications = false;
    },
    toggleMobileMenu() {
      this.showMobileMenu = !this.showMobileMenu;
    },
    toggleSidebar() {
      this.$emit('toggle-sidebar');
    },
    openSignIn() {
      this.$emit('open-signin');
      // Or use router: this.$router.push('/login');
    },
    openRegister() {
      this.$emit('open-register');
      // Or use router: this.$router.push('/register');
    },
    logout() {
      // Call API to logout
      this.isAuthenticated = false;
      this.showProfile = false;
      this.showMobileMenu = false;
      this.$router.push('/');
    }
  },
  mounted() {
    // Check authentication status
    // this.isAuthenticated = !!localStorage.getItem('authToken');
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', (e) => {
      if (!e.target.closest('#notificationButton') && !e.target.closest('#notificationDropdown')) {
        this.showNotifications = false;
      }
      if (!e.target.closest('#profileButton') && !e.target.closest('#profileDropdown')) {
        this.showProfile = false;
      }
      if (!e.target.closest('#mobileMenuButton') && !e.target.closest('#mobileMenu')) {
        this.showMobileMenu = false;
      }
    });
  },
  beforeUnmount() {
    document.removeEventListener('click', this.handleClickOutside);
  }
}
</script>

<style scoped>
/* Navigation transitions */
header {
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(10px);
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

/* Smooth dropdown animations */
div[id*="Dropdown"] {
  animation: slideDown 0.2s ease-out;
}

@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Mobile menu animation */
#mobileMenu {
  animation: slideDown 0.2s ease-out;
}

/* Active router link styling */
:deep(.router-link-active) {
  color: #06b6d4;
  font-weight: 600;
}
</style>
