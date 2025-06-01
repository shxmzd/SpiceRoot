<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    <title>{{ $title ?? 'SpiceRoot' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js for dropdown functionality -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Roboto:wght@300;400&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            perspective: 1200px;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            overflow-x: hidden;
        }
        h1, h2, h3 {
            font-family: 'Cinzel', serif;
        }
        .card-3d {
            transition: transform 0.4s ease, box-shadow 0.4s ease, background 0.3s ease;
            transform: translateZ(0) rotateX(2deg);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.6), 0 8px 8px rgba(0, 0, 0, 0.4);
            background: linear-gradient(145deg, #2a2a2a, #1f1f1f);
            position: relative;
            overflow: hidden;
        }
        .card-3d:hover {
            transform: translateY(-15px) translateZ(60px) rotateX(8deg) rotateY(8deg);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.8), 0 12px 12px rgba(0, 0, 0, 0.5);
            background: linear-gradient(145deg, #3a3a3a, #2a2a2a);
        }
        .card-3d::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 167, 38, 0.2), transparent);
            transition: 0.8s;
        }
        .card-3d:hover::before {
            left: 100%;
        }
        .button-3d {
            position: relative;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.5);
            background: linear-gradient(145deg, #16a34a, #15803d);
        }
        .button-3d:hover {
            transform: translateY(-4px) translateZ(15px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.7);
        }
        .glow {
            animation: glow 2s infinite alternate;
        }
        @keyframes glow {
            0% { text-shadow: 0 0 5px rgba(255, 167, 38, 0.5); }
            100% { text-shadow: 0 0 15px rgba(255, 167, 38, 0.8), 0 0 20px rgba(255, 167, 38, 0.4); }
        }
        .sparkle {
            position: relative;
        }
        .sparkle::after {
            content: '';
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255, 167, 38, 0.8);
            border-radius: 50%;
            top: 10%;
            left: 90%;
            animation: sparkle 1.5s infinite;
            opacity: 0;
        }
        @keyframes sparkle {
            0% { transform: scale(1); opacity: 0; }
            50% { transform: scale(1.5); opacity: 1; }
            100% { transform: scale(1); opacity: 0; }
        }
        .bg-particle {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            background: url('data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"%3E%3Ccircle cx="10" cy="10" r="2" fill="rgba(255,167,38,0.3)"/%3E%3Ccircle cx="90" cy="20" r="3" fill="rgba(22,163,74,0.3)"/%3E%3Ccircle cx="50" cy="80" r="2" fill="rgba(255,167,38,0.3)"/%3E%3C/svg%3E') repeat;
            animation: particle-float 20s infinite linear;
            z-index: -1;
        }
        @keyframes particle-float {
            0% { background-position: 0 0; }
            100% { background-position: 100px 100px; }
        }
        .hero-bg {
            position: relative;
            overflow: hidden;
            background: linear-gradient(145deg, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.7)), url('{{ asset("images/anju-ravindranath-Nihdo084Yos-unsplash.jpg") }}') center/cover;
        }
        .hero-bg::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 167, 38, 0.2) 0%, transparent 70%);
            animation: pulse 10s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); opacity: 0.3; }
            50% { transform: scale(1.2); opacity: 0.5; }
            100% { transform: scale(1); opacity: 0.3; }
        }
        .recently-viewed-container {
            scrollbar-width: thin;
            scrollbar-color: #f97316 transparent;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
        }
        .recently-viewed-container::-webkit-scrollbar {
            height: 10px;
        }
        .recently-viewed-container::-webkit-scrollbar-track {
            background: #2d2d2d;
            border-radius: 5px;
        }
        .recently-viewed-container::-webkit-scrollbar-thumb {
            background: #f97316;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }
    </style>
    @livewireStyles
</head>
<body class="relative">    <!-- Navigation Bar -->
    <header class="py-6 px-4 md:px-8 bg-gray-900 shadow-lg">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <img src="{{ asset('images/spiceroot_logo.png') }}" alt="SpiceRoot Logo" class="h-12 w-auto">
                <h1 class="text-3xl font-bold text-orange-500">SpiceRoot</h1>
            </div>
            
            <div class="flex items-center space-x-6">
                <!-- Main Navigation -->
                <nav class="hidden md:flex space-x-4">
                    <a href="{{ route('buyer.dashboard') }}" class="text-gray-300 hover:text-orange-500 transition duration-300 sparkle">Home</a>
                    <a href="{{ route('buyer.shop') }}" class="text-gray-300 hover:text-orange-500 transition duration-300 sparkle">Shop</a>
                    <a href="{{ route('buyer.cart') }}" class="text-gray-300 hover:text-orange-500 transition duration-300 sparkle">Cart</a>
                    <a href="{{ route('buyer.wishlist') }}" class="text-gray-300 hover:text-orange-500 transition duration-300 sparkle">Wishlist</a>
                    <a href="{{ route('buyer.orders') }}" class="text-gray-300 hover:text-orange-500 transition duration-300 sparkle">Orders</a>
                </nav>

                <!-- User Dropdown -->
                @auth
                <div class="relative" x-data="{ open: false }">
                    <!-- Dropdown Trigger -->
                    <button @click="open = !open" @click.away="open = false" 
                            class="flex items-center space-x-2 text-sm font-medium text-gray-300 hover:text-white bg-gray-800 hover:bg-gray-700 px-3 py-2 rounded-lg transition-colors duration-150">
                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <img class="h-8 w-8 rounded-full object-cover border-2 border-gray-600" 
                                 src="{{ Auth::user()->profile_photo_url }}" 
                                 alt="{{ Auth::user()->name }}" />
                        @else
                            <div class="h-8 w-8 rounded-full bg-gray-600 flex items-center justify-center">
                                <span class="text-xs font-medium text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                        @endif
                        <span class="hidden sm:block">{{ Auth::user()->name }}</span>
                        <svg class="h-4 w-4 transition-transform duration-200" :class="{ 'rotate-180': open }" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 bg-gray-800 border border-gray-700 rounded-lg shadow-xl z-50"
                         style="display: none;">
                        
                        <div class="py-1">
                            <!-- Account Management -->
                            <div class="px-4 py-2 text-xs text-gray-400 border-b border-gray-700">
                                Account Management
                            </div>
                            
                            <a href="{{ route('profile.show') }}" 
                               class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Profile
                            </a>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <a href="{{ route('api-tokens.index') }}" 
                                   class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                    </svg>
                                    API Tokens
                                </a>
                            @endif

                            <div class="border-t border-gray-700"></div>

                            <!-- Logout -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="flex items-center w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-red-400 transition-colors">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endauth

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" 
                            class="text-gray-300 hover:text-white p-2">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-data="{ mobileMenuOpen: false }" x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="transform opacity-0 scale-95"
             x-transition:enter-end="transform opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-75"
             x-transition:leave-start="transform opacity-100 scale-100"
             x-transition:leave-end="transform opacity-0 scale-95"
             class="md:hidden mt-4 pb-4 border-t border-gray-700"
             style="display: none;">
            <nav class="flex flex-col space-y-2 px-4">
                <a href="{{ route('buyer.dashboard') }}" class="text-gray-300 hover:text-orange-500 py-2 transition duration-300">Home</a>
                <a href="{{ route('buyer.shop') }}" class="text-gray-300 hover:text-orange-500 py-2 transition duration-300">Shop</a>
                <a href="{{ route('buyer.cart') }}" class="text-gray-300 hover:text-orange-500 py-2 transition duration-300">Cart</a>
                <a href="{{ route('buyer.wishlist') }}" class="text-gray-300 hover:text-orange-500 py-2 transition duration-300">Wishlist</a>
                <a href="{{ route('buyer.orders') }}" class="text-gray-300 hover:text-orange-500 py-2 transition duration-300">Orders</a>
                
                @auth
                <div class="border-t border-gray-700 pt-2 mt-2">
                    <a href="{{ route('profile.show') }}" class="text-gray-300 hover:text-orange-500 py-2 transition duration-300 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-300 hover:text-red-400 py-2 transition duration-300 flex items-center w-full text-left">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Log Out
                        </button>
                    </form>
                </div>
                @endauth
            </nav>
        </div>
    </header>
    
    <div class="bg-particle"></div>

    <!-- Main Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 py-10 px-4 text-center transform translateZ(30px)">
        <h3 class="text-3xl font-bold text-orange-500 glow">SpiceRoot</h3>
        <p class="mt-3 text-lg text-gray-400">Bringing the world's finest spices and herbs to your kitchen.</p>
        <div class="mt-6 flex justify-center space-x-6">
            <a href="#" class="text-gray-400 hover:text-orange-500 transition duration-300 sparkle text-lg">About Us</a>
            <a href="#" class="text-gray-400 hover:text-orange-500 transition duration-300 sparkle text-lg">Contact</a>
            <a href="#" class="text-gray-400 hover:text-orange-500 transition duration-300 sparkle text-lg">FAQs</a>
        </div>
        <p class="mt-6 text-gray-500">© 2025 SpiceRoot. All rights reserved.</p>
    </footer>

    @livewireScripts
    @stack('scripts')
</body>
</html>