<x-user.layout>
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-cyan-900 flex items-center justify-center px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-cyan-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-red-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute top-1/2 left-1/2 w-80 h-80 bg-cyan-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
    </div>

    <div class="relative z-10 text-center">
        <!-- 404 Illustration -->
        <div class="mb-8 animate-float">
            <div class="inline-block relative">
                <!-- Large 404 with gradient -->
                <h1 class="text-9xl md:text-[150px] font-black bg-gradient-to-r from-cyan-400 via-blue-500 to-cyan-400 bg-clip-text text-transparent drop-shadow-2xl" style="line-height: 1;">
                    404
                </h1>
                
                <!-- Animated circles around 404 -->
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                    <div class="absolute w-32 h-32 border-2 border-cyan-500/30 rounded-full animate-spin" style="animation-duration: 8s;"></div>
                    <div class="absolute w-48 h-48 border-2 border-blue-500/20 rounded-full animate-spin" style="animation-duration: 12s; animation-direction: reverse;"></div>
                </div>
            </div>
        </div>

        <!-- Error Message -->
        <div class="mb-8 animate-fade-in" style="animation-delay: 0.2s;">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">
                Page Not Found
            </h2>
            <p class="text-xl text-cyan-200 max-w-xl mx-auto">
                Sorry, we couldn't find the page you're looking for. It might have been moved or deleted. Let's get you back on track!
            </p>
        </div>

       
        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8 animate-fade-in" style="animation-delay: 0.4s;">
            <a href="/" class="px-8 py-3 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-bold shadow-lg hover:shadow-xl hover:from-cyan-600 hover:to-blue-700 transition-all duration-300 transform hover:scale-105 inline-flex items-center justify-center gap-2 group">
                <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Home
            </a>
            <a href="/contact" class="px-8 py-3 rounded-lg bg-white/10 border-2 border-white/30 hover:border-cyan-400 text-white font-bold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 inline-flex items-center justify-center gap-2 group">
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                Get Support
            </a>
        </div>

        <!-- Quick Links -->
        <div class="animate-fade-in" style="animation-delay: 0.5s;">
            <p class="text-white/60 mb-4">Or try these popular pages:</p>
            <div class="flex flex-wrap justify-center gap-3">
                <a href="/cars" class="px-4 py-2 rounded-lg bg-white/5 border border-white/20 hover:border-cyan-400 hover:bg-cyan-500/10 text-cyan-400 font-semibold transition-all duration-300 text-sm">
                    Browse Cars
                </a>
                <a href="/bookings" class="px-4 py-2 rounded-lg bg-white/5 border border-white/20 hover:border-cyan-400 hover:bg-cyan-500/10 text-cyan-400 font-semibold transition-all duration-300 text-sm">
                    My Bookings
                </a>
                <a href="/dashboard" class="px-4 py-2 rounded-lg bg-white/5 border border-white/20 hover:border-cyan-400 hover:bg-cyan-500/10 text-cyan-400 font-semibold transition-all duration-300 text-sm">
                    Dashboard
                </a>
                <a href="/help" class="px-4 py-2 rounded-lg bg-white/5 border border-white/20 hover:border-cyan-400 hover:bg-cyan-500/10 text-cyan-400 font-semibold transition-all duration-300 text-sm">
                    Help Center
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-20px);
        }
    }

    @keyframes blob {
        0%, 100% {
            transform: translate(0, 0) scale(1);
        }
        33% {
            transform: translate(30px, -50px) scale(1.1);
        }
        66% {
            transform: translate(-20px, 20px) scale(0.9);
        }
    }

    .animate-fade-in {
        animation: fade-in 0.5s ease-out forwards;
        opacity: 0;
    }

    .animate-float {
        animation: float 3s ease-in-out infinite;
    }

    .animate-blob {
        animation: blob 7s infinite;
    }

    .animation-delay-2000 {
        animation-delay: 2s;
    }

    .animation-delay-4000 {
        animation-delay: 4s;
    }
</style>
@endpush
</x-user.layout>
