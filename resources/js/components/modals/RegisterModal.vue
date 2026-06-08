<template>
  <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
      <!-- Header -->
      <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-slate-900">Create Account</h2>
        <button @click="close" class="text-slate-500 hover:text-slate-900">
          <i data-lucide="x" class="h-6 w-6"></i>
        </button>
      </div>

      <!-- Form -->
      <form @submit.prevent="handleRegister" class="space-y-4">
        <!-- Full Name -->
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Full Name</label>
          <input v-model="fullName" type="text" required
            class="w-full rounded-lg border border-slate-300 px-4 py-2 text-slate-900 placeholder-slate-400 focus:border-cyan-400 focus:outline-none"
            placeholder="John Doe" />
        </div>

        <!-- Email Input -->
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
          <input v-model="email" type="email" required
            class="w-full rounded-lg border border-slate-300 px-4 py-2 text-slate-900 placeholder-slate-400 focus:border-cyan-400 focus:outline-none"
            placeholder="your@email.com" />
        </div>

        <!-- Password Input -->
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Password</label>
          <input v-model="password" type="password" required
            class="w-full rounded-lg border border-slate-300 px-4 py-2 text-slate-900 placeholder-slate-400 focus:border-cyan-400 focus:outline-none"
            placeholder="••••••••" />
        </div>

        <!-- Confirm Password -->
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Confirm Password</label>
          <input v-model="confirmPassword" type="password" required
            class="w-full rounded-lg border border-slate-300 px-4 py-2 text-slate-900 placeholder-slate-400 focus:border-cyan-400 focus:outline-none"
            placeholder="••••••••" />
        </div>

        <!-- Terms Checkbox -->
        <div class="flex items-center">
          <input v-model="agreeToTerms" type="checkbox" id="agreeToTerms" class="h-4 w-4" required />
          <label for="agreeToTerms" class="ml-2 text-sm text-slate-600">
            I agree to the
            <a href="#" class="font-bold text-cyan-600 hover:text-cyan-700">Terms & Conditions</a>
          </label>
        </div>

        <!-- Submit Button -->
        <button type="submit"
          class="w-full rounded-lg bg-cyan-400 py-2 font-bold text-slate-950 transition hover:bg-cyan-300">
          Create Account
        </button>
      </form>

      <!-- Divider -->
      <div class="my-6 flex items-center">
        <div class="flex-1 border-t border-slate-200"></div>
        <span class="px-3 text-sm text-slate-500">or</span>
        <div class="flex-1 border-t border-slate-200"></div>
      </div>

      <!-- Footer -->
      <p class="text-center text-sm text-slate-600">
        Already have an account?
        <button type="button" @click="switchToSignIn" class="font-bold text-cyan-600 hover:text-cyan-700">
          Sign In
        </button>
      </p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'RegisterModal',
  data() {
    return {
      isOpen: true,
      fullName: '',
      email: '',
      password: '',
      confirmPassword: '',
      agreeToTerms: false
    }
  },
  methods: {
    close() {
      this.$emit('close')
    },
    handleRegister() {
      if (this.password !== this.confirmPassword) {
        alert('Passwords do not match')
        return
      }
      // Handle registration logic
      console.log('Register:', {
        fullName: this.fullName,
        email: this.email,
        password: this.password
      })
      this.close()
    },
    switchToSignIn() {
      this.$emit('close')
      this.$emit('switch-to-signin')
    }
  }
}
</script>

<style scoped>
/* Modal fade animation */
div {
  animation: fadeIn 0.2s ease-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}
</style>
