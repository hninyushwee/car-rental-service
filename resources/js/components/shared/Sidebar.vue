<template>
  <aside id="dashboardSidebar" 
    class="fixed left-0 top-0 z-40 h-screen w-60 border-r border-slate-200 bg-white transition-all duration-300 overflow-hidden"
    :class="{ 'w-16': collapsed, 'md:w-20': collapsed }">
    
    <!-- Sidebar Header -->
    <div class="flex items-center justify-between border-b border-slate-200 p-4">
      <div v-if="!collapsed" class="flex items-center gap-2">
        <img :src="logo" alt="Logo" class="h-8 w-8 object-contain" />
        <p id="logoText" class="font-black text-sm text-cyan-600">SkyLine</p>
      </div>
      <button @click="$emit('toggle')" 
        class="flex h-8 w-8 items-center justify-center rounded border border-slate-300 hover:bg-slate-100">
        <i :data-lucide="collapsed ? 'panel-right' : 'panel-left'" class="h-4 w-4"></i>
      </button>
    </div>

    <!-- Navigation Menu -->
    <nav class="space-y-2 p-3">
      <router-link to="/" class="flex items-center gap-3 rounded px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">
        <i data-lucide="home" class="h-5 w-5"></i>
        <span v-if="!collapsed" data-sidebar-label>Dashboard</span>
      </router-link>
      <router-link to="/bookings" class="flex items-center gap-3 rounded px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">
        <i data-lucide="calendar" class="h-5 w-5"></i>
        <span v-if="!collapsed" data-sidebar-label>Bookings</span>
      </router-link>
      <router-link to="/vehicles" class="flex items-center gap-3 rounded px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">
        <i data-lucide="car" class="h-5 w-5"></i>
        <span v-if="!collapsed" data-sidebar-label>Vehicles</span>
      </router-link>
      <router-link to="/drivers" class="flex items-center gap-3 rounded px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">
        <i data-lucide="users" class="h-5 w-5"></i>
        <span v-if="!collapsed" data-sidebar-label>Drivers</span>
      </router-link>
      <router-link to="/payments" class="flex items-center gap-3 rounded px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">
        <i data-lucide="credit-card" class="h-5 w-5"></i>
        <span v-if="!collapsed" data-sidebar-label>Payments</span>
      </router-link>
    </nav>

    <!-- Sidebar Footer -->
    <div class="absolute bottom-0 left-0 right-0 border-t border-slate-200 p-3">
      <button @click="logout" class="flex w-full items-center gap-3 rounded px-3 py-2 text-sm font-medium text-rose-600 hover:bg-rose-50">
        <i data-lucide="log-out" class="h-5 w-5"></i>
        <span v-if="!collapsed" data-sidebar-label>Logout</span>
      </button>
    </div>
  </aside>
</template>

<script>
import logo from '../assets/images/logo.png'
export default {
  name: 'Sidebar',
  props: {
    collapsed: {
      type: Boolean,
      default: false
    }
  },
  emits: ['toggle'],
  methods: {
    logout() {
      this.$emit('logout')
      this.$router.push('/')
    }
  }
}
</script>

<style scoped>
aside {
  padding-bottom: 80px;
}
</style>
