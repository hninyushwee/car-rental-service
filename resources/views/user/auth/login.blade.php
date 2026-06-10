<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="SkyLine Automotive landing page and customer portal skeleton." />
    <title>SkyLine Automotive | Landing & Portal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <title>Document</title>
    <style>
            @keyframes fade-in {
                from {
                    opacity:
                        0;
                    transform:
                        translateY(20px);
                }

                to {
                    opacity:
                        1;
                    transform:
                        translateY(0);
                }
            }

            @keyframes blob {

                0%,
                100% {
                    transform:
                        translate(0,
                            0) scale(1);
                }

                33% {
                    transform:
                        translate(30px,
                            -50px) scale(1.1);
                }

                66% {
                    transform:
                        translate(-20px,
                            20px) scale(0.9);
                }
            }

            .animate-fade-in {
                animation:
                    fade-in 0.5s ease-out forwards;
                opacity:
                    0;
            }

            .animate-blob {
                animation:
                    blob 7s infinite;
            }

            .animation-delay-2000 {
                animation-delay:
                    2s;
            }

            .animation-delay-4000 {
                animation-delay:
                    4s;
            }
        </style>
</head>
<body>
     <div>
        <div
            class="py-8 sm:py-6 min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-cyan-900 flex items-center justify-center px-8 sm:px-10 lg:px-12 relative overflow-hidden">
            <!-- Animated Background Elements -->
            <div class="absolute inset-0 overflow-hidden">
                <div
                    class="absolute -top-40 -right-40 w-80 h-80 bg-cyan-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob">
                </div>
                <div
                    class="absolute -bottom-40 -left-40 w-80 h-80 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000">
                </div>
                <div
                    class="absolute top-1/2 left-1/2 w-80 h-80 bg-cyan-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000">
                </div>
            </div>

            <div class="relative z-10 w-full max-w-md">
                <!-- Logo/Branding -->
                <div class="text-center mb-8 animate-fade-in">
                    <img class="mx-auto h-16 w-16 object-contain sm:h-20 sm:w-20 md:h-24 md:w-24 mb-1"
                        src="{{ asset('images/logo.png') }}" alt="SkyLine Automotive logo" />

                    <h1 class="text-2xl text-white mb-1">Sign in to SkyLine</h1>
                </div>

                <!-- Login Card -->
                <div class="bg-white/10 backdrop-blur-md rounded-2xl shadow-2xl p-8 border border-white/20 animate-fade-in"
                    style="animation-delay: 0.1s;">
                    <form action="#" method="POST" class="space-y-4">
                        @csrf

                        <!-- Email -->
                        <div class="group">
                            <label for="email" class="block text-sm font-semibold text-white">
                                <span class="inline-flex items-center gap-2">
                                    <i data-lucide="mail" class="w-5 h-5 text-cyan-400"></i>
                                    Email Address
                                </span>
                            </label>
                            <div class="relative">
                                <input type="email" id="email" name="email" placeholder="your@email.com"
                                    required
                                    class="w-full px-4 py-2 rounded-lg bg-white/10 border-2 border-white/20 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 transition-all duration-300 placeholder-white/50 text-white backdrop-blur-sm group-hover:border-white/30">
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="group">
                            <label for="password" class="block text-sm font-semibold text-white mb-1">
                                <span class="inline-flex items-center gap-2">
                                    <i data-lucide="key" class="w-5 h-5 text-cyan-400"></i>
                                    Password
                                </span>
                            </label>
                            <div class="relative">
                                <input type="password" id="password" name="password" placeholder="••••••••" required
                                    class="w-full px-4 py-2 rounded-lg bg-white/10 border-2 border-white/20 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 transition-all duration-300 placeholder-white/50 text-white backdrop-blur-sm group-hover:border-white/30">
                            </div>
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" name="remember"
                                    class="w-4 h-4 rounded-lg bg-white/10 border-2 border-white/20 checked:bg-cyan-500 checked:border-cyan-500 focus:ring-2 focus:ring-cyan-400/30 cursor-pointer transition-all duration-300">
                                <span
                                    class="text-sm font-medium text-white/80 group-hover:text-white transition-colors">Remember
                                    me</span>
                            </label>
                            <a href="#"
                                class="text-sm font-semibold text-cyan-400 hover:text-cyan-300 transition-colors duration-300">
                                Forgot password?
                            </a>
                        </div>

                        <!-- Login Button -->
                        <button type="submit"
                            class="w-full py-2 px-6 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-bold shadow-lg hover:shadow-xl hover:from-cyan-600 hover:to-blue-700 transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-2 group">
                            <i data-lucide="log-in" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
                            Sign In
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="flex items-center gap-3 my-6">
                        <div class="flex-1 h-px bg-white/20"></div>
                        <span class="text-xs font-medium text-white/50">OR</span>
                        <div class="flex-1 h-px bg-white/20"></div>
                    </div>

                    <!-- Social Login -->
                    <div class="grid grid-cols-2 gap-3 mb-6">
                        <button type="button"
                            class="px-4 py-2 rounded-lg bg-white/10 border-2 border-white/20 hover:border-white/40 text-white font-semibold transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-2">
                            <i data-lucide="chrome" class="w-5 h-5"></i>
                            <span class="text-sm">Google</span>
                        </button>
                        <button type="button"
                            class="px-4 py-2 rounded-lg bg-white/10 border-2 border-white/20 hover:border-white/40 text-white font-semibold transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-2">
                            <i data-lucide="github" class="w-5 h-5"></i>
                            <span class="text-sm">GitHub</span>
                        </button>
                    </div>

                    <!-- Sign Up Link -->
                    <p class="text-center text-white/70">
                        Don't have an account?
                        <a href="/register" class="font-bold text-cyan-400 hover:text-cyan-300 transition-colors">
                            Create one now
                        </a>
                    </p>
                </div>

                <!-- Footer -->
                <p class="text-center text-white/50 text-xs mt-8">
                    By signing in, you agree to our <a href="#" class="text-cyan-400 hover:underline">Terms of
                        Service</a>
                    and <a href="#" class="text-cyan-400 hover:underline">Privacy Policy</a>
                </p>
            </div>
        </div>
        <footer class="mt-auto py-4 border-t bg-slate-950 border-white/5 w-full">
            <p class="text-center text-white/50 text-xs">
                By signing in, you agree to our <a href="#" class="text-cyan-400 hover:underline">Terms of
                    Service</a>
                and <a href="#" class="text-cyan-400 hover:underline">Privacy Policy</a>
            </p>
        </footer>
    </div>
</body>
</html>


