<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="SkyLine Automotive landing page and customer portal skeleton." />
    <title>SkyLine Automotive | Landing & Portal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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

        @keyframes blob {

            0%,
            100% {
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
</head>

<body>
    <div>
        <div
            class="pt-6 sm:pt-4 pb-8 sm:pb-6 min-h-screen bg-gradient-to-br from-slate-950 to-slate-800 flex items-center justify-center px-8 sm:px-10 lg:px-12 relative overflow-hidden">
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
                <div class="text-center mb-5 animate-fade-in">
                    <img class="mx-auto h-10 w-10 object-contain sm:h-14 sm:w-14 md:h-18 md:w-18"
                        src="{{ asset('images/logo.png') }}" alt="SkyLine Automotive logo" />
                    <h1 class="text-2xl text-white mb-1">@yield('header')</h1>
                </div>
                {{ $slot }}
                <p class="text-center text-white/50 text-xs mt-8">
                    By signing in, you agree to our <a href="#" class="text-cyan-400 hover:underline">Terms of
                        Service</a> and <a href="#" class="text-cyan-400 hover:underline">Privacy Policy</a>
                </p>
            </div>
        </div>
    </div>
</body>
@stack('scripts')
</html>
