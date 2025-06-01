<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Authentication</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&family=cinzel:400,700&family=roboto:300,400&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
        
        <style>
            :root {
                --orange-primary: #FF6B35;
                --orange-dark: #E85D04;
                --black-primary: #1A1A1A;
                --black-secondary: #2A2922;
                --cream: #FFF3E0;
                --white: #FFFFFF;
                --gray-light: #F5F5F5;
                --green-accent: #16a34a;
            }

            body {
                font-family: 'Roboto', sans-serif;
                background: linear-gradient(135deg, var(--black-primary), #2d2d2d);
                overflow-x: hidden;
                line-height: 1.7;
            }

            h1, h2, h3 {
                font-family: 'Cinzel', serif;
            }

            /* Background Particle Effect */
            .bg-particle {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                pointer-events: none;
                background: url('data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"%3E%3Ccircle cx="10" cy="10" r="2" fill="rgba(255,107,53,0.3)"/%3E%3Ccircle cx="90" cy="20" r="3" fill="rgba(22,163,74,0.3)"/%3E%3Ccircle cx="50" cy="80" r="2" fill="rgba(255,107,53,0.3)"/%3E%3C/svg%3E') repeat;
                z-index: -1;
            }

            /* Glassmorphism Effect */
            .glass-effect {
                background: rgba(26, 26, 26, 0.7);
                backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 107, 53, 0.2);
                border-radius: 1rem;
            }

            /* Button Effects */
            .btn-3d {
                background: linear-gradient(145deg, var(--orange-primary), var(--orange-dark));
                font-family: 'Roboto', sans-serif;
                font-weight: 600;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            }

            .btn-3d:hover {
                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4);
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-black text-white">
        <div class="bg-particle"></div>
        
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <!-- Logo/Header -->
            <div class="relative z-10 mb-8">
                <a href="/" class="flex items-center space-x-3 group">
                    <div class="h-12 w-12 rounded-full border-2 border-orange-500 bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <span class="text-xl font-bold text-white">S</span>
                    </div>
                    <span class="text-2xl font-bold text-orange-500" style="font-family: 'Cinzel', serif;">SpiceHub</span>
                </a>
                <p class="text-center text-gray-400 mt-2 text-sm">Premium Spices Marketplace</p>
            </div>

            <!-- Authentication Card -->
            <div class="relative z-10 w-full sm:max-w-md mt-6 px-8 py-10 glass-effect shadow-2xl rounded-2xl">
                {{ $slot }}
            </div>

            <!-- Back to Home Link -->
            <div class="relative z-10 mt-6">
                <a href="/" class="text-gray-400 hover:text-orange-500 text-sm transition-colors flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Back to Home</span>
                </a>
            </div>
        </div>

        </div>

        @livewireScripts
    </body>
</html>