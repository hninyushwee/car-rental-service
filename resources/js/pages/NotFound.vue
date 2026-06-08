<template>
  <div class="min-h-screen bg-slate-50 flex flex-col items-center justify-center px-4">
    <div class="text-center max-w-md">
      <!-- Icon -->
      <div class="mb-6 flex justify-center">
        <div class="h-20 w-20 rounded-full bg-slate-200 flex items-center justify-center">
          <i data-lucide="search" class="h-10 w-10 text-slate-600"></i>
        </div>
      </div>

      <!-- Title -->
      <h1 class="text-4xl font-black text-slate-950 mb-4">404</h1>

      <!-- Message -->
      <p class="text-xl font-bold text-slate-900 mb-2">Page Not Found</p>
      <p class="text-slate-600 mb-8">
        The page you're looking for doesn't exist. It might have been moved or deleted.
      </p>

      <!-- Action Buttons -->
      <div class="flex flex-col gap-3 sm:flex-row sm:justify-center">
        <router-link to="/"
          class="rounded-lg bg-cyan-400 px-6 py-3 font-bold text-slate-950 transition hover:bg-cyan-300">
          Go Home
        </router-link>
        <button @click="goBack"
          class="rounded-lg border border-slate-300 px-6 py-3 font-bold text-slate-700 transition hover:bg-slate-100">
          Go Back
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'NotFound',
  methods: {
    goBack() {
      this.$router.back()
    }
  }
}
</script>

<style scoped>
/* Page styles */
</style>
