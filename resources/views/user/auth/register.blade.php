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
    <style>
        <style>@keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
        }
    </style>
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

            <div class="relative z-10 w-full max-w-xl">
                <!-- Logo/Branding -->
                <div class="text-center mb-8 animate-fade-in">
                    <img class="mx-auto h-16 w-16 object-contain sm:h-20 sm:w-20 md:h-24 md:w-24"
                        src="{{ asset('images/logo.png') }}" alt="SkyLine Automotive logo" />

                    <h1 class="text-2xl text-white mb-1">Create account for SkyLine</h1>
                </div>

                <!-- Registration Card -->
                <div class="bg-white/10 backdrop-blur-md rounded-2xl shadow-2xl p-8 border border-white/20 animate-fade-in"
                    style="animation-delay: 0.1s;">

                    <form action="#" method="POST" class="space-y-4">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- First Name -->
                            <div class="group">
                                <label for="first_name" class="block text-sm font-semibold text-white mb-2">
                                    First Name
                                </label>
                                <input type="text" id="first_name" name="first_name" placeholder="John" required
                                    class="w-full px-4 py-2 rounded-lg bg-white/10 border-2 border-white/20 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 transition-all duration-300 placeholder-white/50 text-white backdrop-blur-sm group-hover:border-white/30">
                            </div>

                            <!-- Last Name -->
                            <div class="group">
                                <label for="last_name" class="block text-sm font-semibold text-white mb-2">
                                    Last Name
                                </label>
                                <input type="text" id="last_name" name="last_name" placeholder="Doe" required
                                    class="w-full px-4 py-2 rounded-lg bg-white/10 border-2 border-white/20 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 transition-all duration-300 placeholder-white/50 text-white backdrop-blur-sm group-hover:border-white/30">
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="group">
                            <label for="email" class="block text-sm font-semibold text-white mb-2">
                                <span class="inline-flex items-center gap-2">
                                    <i data-lucide="mail" class="w-5 h-5 text-cyan-400"></i>
                                    Email Address
                                </span>
                            </label>
                            <input type="email" id="email" name="email" placeholder="your@email.com" required
                                class="w-full px-4 py-2 rounded-lg bg-white/10 border-2 border-white/20 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 transition-all duration-300 placeholder-white/50 text-white backdrop-blur-sm group-hover:border-white/30">
                        </div>

                        <!-- Password -->
                        <div class="group">
                            <label for="password" class="block text-sm font-semibold text-white mb-2">
                                <span class="inline-flex items-center gap-2">
                                    <i data-lucide="key" class="w-5 h-5 text-cyan-400"></i>
                                    Password
                                </span>
                            </label>
                            <input type="password" id="password" name="password" placeholder="••••••••" required
                                class="w-full px-4 py-2 rounded-lg bg-white/10 border-2 border-white/20 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 transition-all duration-300 placeholder-white/50 text-white backdrop-blur-sm group-hover:border-white/30">
                        </div>

                        <!-- Confirm Password -->
                        <div class="group">
                            <label for="password_confirmation" class="block text-sm font-semibold text-white mb-2">
                                <span class="inline-flex items-center gap-2">
                                    <i data-lucide="shield-check" class="w-5 h-5 text-cyan-400"></i>
                                    Confirm Password
                                </span>
                            </label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                placeholder="••••••••" required
                                class="w-full px-4 py-2 rounded-lg bg-white/10 border-2 border-white/20 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 transition-all duration-300 placeholder-white/50 text-white backdrop-blur-sm group-hover:border-white/30">
                        </div>

                        <!-- Phone -->
                        <div class="group">
                            <label for="phone" class="block text-sm font-semibold text-white mb-2">
                                <span class="inline-flex items-center gap-2">
                                    <i data-lucide="phone" class="w-5 h-5 text-cyan-400"></i>
                                    Phone Number
                                </span>
                            </label>
                            <input type="tel" id="phone" name="phone" placeholder="+95 9123 456 789"
                                class="w-full px-4 py-2 rounded-lg bg-white/10 border-2 border-white/20 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 transition-all duration-300 placeholder-white/50 text-white backdrop-blur-sm group-hover:border-white/30">
                        </div>

                        <!-- Terms -->
                        <label class="flex items-start gap-3 cursor-pointer group">
                            <input type="checkbox" name="terms" required
                                class="w-5 h-5 rounded-lg bg-white/10 border-2 border-white/20 checked:bg-cyan-500 checked:border-cyan-500 focus:ring-2 focus:ring-cyan-400/30 cursor-pointer transition-all duration-300 mt-0.5">
                            <span class="text-sm font-medium text-white/80 group-hover:text-white transition-colors">I
                                agree to the <a href="#" class="text-cyan-400 hover:underline">Terms of
                                    Service</a> and <a href="#" class="text-cyan-400 hover:underline">Privacy
                                    Policy</a></span>
                        </label>

                        <!-- Register Button -->
                        <button type="submit"
                            class="w-full py-2 px-6 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-bold shadow-lg hover:shadow-xl hover:from-cyan-600 hover:to-blue-700 transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-2 group">
                            <i data-lucide="user-check"
                                class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
                            Create Account
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="flex items-center gap-3 my-6">
                        <div class="flex-1 h-px bg-white/20"></div>
                        <span class="text-xs font-medium text-white/50">OR</span>
                        <div class="flex-1 h-px bg-white/20"></div>
                    </div>

                    <!-- Login Link -->
                    <p class="text-center text-white/70">
                        Already have an account?
                        <a href="/login" class="font-bold text-cyan-400 hover:text-cyan-300 transition-colors">
                            Sign in here
                        </a>
                    </p>
                </div>
            </div>
        </div>
        <!-- Footer -->
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
