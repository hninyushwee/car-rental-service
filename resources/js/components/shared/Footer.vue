<template>
  <footer class="border-t border-slate-200 bg-slate-950 py-12 text-slate-200">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="grid gap-8 md:grid-cols-4 sm:grid-cols-2">
        <!-- Brand -->
        <div>
          <h3 class="font-black text-white mb-4">SkyLine</h3>
          <p class="text-sm text-slate-400">Premium automotive solutions for modern mobility.</p>
        </div>

        <!-- Quick Links -->
        <div>
          <h4 class="font-bold text-white mb-4">Quick Links</h4>
          <ul class="space-y-2 text-sm">
            <li><router-link to="/" class="hover:text-cyan-400 transition">Home</router-link></li>
            <li><router-link to="/about" class="hover:text-cyan-400 transition">About</router-link></li>
            <li><router-link to="/contact" class="hover:text-cyan-400 transition">Contact</router-link></li>
          </ul>
        </div>

        <!-- Services -->
        <div>
          <h4 class="font-bold text-white mb-4">Services</h4>
          <ul class="space-y-2 text-sm">
            <li><a href="#" class="hover:text-cyan-400 transition">Car Rental</a></li>
            <li><a href="#" class="hover:text-cyan-400 transition">Driver Service</a></li>
            <li><a href="#" class="hover:text-cyan-400 transition">Licensing</a></li>
          </ul>
        </div>

        <!-- Contact -->
        <div>
          <h4 class="font-bold text-white mb-4">Contact</h4>
          <p class="text-sm mb-2">
            <i data-lucide="mail" class="inline h-4 w-4"></i>
            support@skyline.demo
          </p>
          <p class="text-sm">
            <i data-lucide="phone" class="inline h-4 w-4"></i>
            +1 (555) 123-4567
          </p>
        </div>
      </div>

      <!-- Footer Bottom -->
      <div class="mt-8 border-t border-slate-800 pt-8 text-center text-sm text-slate-400">
        <p>&copy; 2026 SkyLine Automotive. All rights reserved.</p>
      </div>
    </div>
  </footer>
</template>

<script>
export default {
  name: 'Footer'
}
</script>

<style scoped>
footer {
  margin-top: auto;
}
</style>
