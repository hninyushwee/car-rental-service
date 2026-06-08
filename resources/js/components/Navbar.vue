<template>
  <header class="fixed inset-x-0 top-0 z-50 bg-white shadow">
    <nav class="flex justify-between p-4">
      <div class="font-bold text-cyan-500">
        SkyLine (Vue Navbar)
      </div>

      <button @click="toggle">
        {{ isLoggedIn ? 'Logout' : 'Login' }}
      </button>
    </nav>
  </header>
</template>

<script setup>
import { ref } from 'vue'

const isLoggedIn = ref(false)

function toggle() {
  isLoggedIn.value = !isLoggedIn.value
}
</script>