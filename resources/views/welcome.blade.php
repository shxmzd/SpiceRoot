<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SpiceHub - Premium Spices Marketplace</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&family=cinzel:400,700&family=roboto:300,400&display=swap" rel="stylesheet" />
        
        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Swiper CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
        
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

            /* Simple Card Effects - No animations */
            .card-3d {
                background: linear-gradient(145deg, #2a2a2a, #1f1f1f);
                border-radius: 1rem;
                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.4);
                overflow: hidden;
            }

            .card-3d:hover {
                box-shadow: 0 12px 24px rgba(0, 0, 0, 0.6);
            }

            /* Simple Button Effects */
            .btn-3d {
                background: linear-gradient(145deg, var(--orange-primary), var(--orange-dark));
                font-family: 'Roboto', sans-serif;
                font-weight: 600;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            }

            .btn-3d:hover {
                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4);
            }

            /* Remove glow animations */
            .glow {
                color: var(--orange-primary);
            }

            /* Simple sparkle effect */
            .sparkle {
                color: inherit;
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

            /* Image Slider Specific Styles */
            .image-slider {
                position: relative;
                height: 70vh;
                min-height: 450px;
                max-height: 700px;
                border-radius: 20px;
                overflow: hidden;
                box-shadow: 0 0 30px rgba(255, 107, 53, 0.3);
                width: 100%;
            }

            .swiper-wrapper {
                height: 100%;
            }

            .swiper-slide {
                position: relative;
                height: 100%;
            }

            .swiper-slide .overlay {
                position: absolute;
                inset: 0;
                background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
                display: flex;
                flex-direction: column;
                justify-content: flex-end;
                padding: 2rem;
                opacity: 0.9;
            }

            .swiper-pagination-bullet {
                background: var(--white);
                opacity: 0.5;
            }

            .swiper-pagination-bullet-active {
                background: var(--orange-primary);
                opacity: 1;
            }

            /* Spice Scroll Container */
            .spice-scroll-container {
                display: flex;
                overflow-x: auto;
                scroll-behavior: smooth;
                scrollbar-width: thin;
                scrollbar-color: var(--orange-primary) #2a2a2a;
                padding: 1rem;
                gap: 1rem;
                justify-content: flex-start;
                width: 100%;
                margin: 0 auto;
            }

            .spice-scroll-container::-webkit-scrollbar {
                height: 6px;
            }

            .spice-scroll-container::-webkit-scrollbar-track {
                background: #2a2a2a;
                border-radius: 10px;
            }

            .spice-scroll-container::-webkit-scrollbar-thumb {
                background: var(--orange-primary);
                border-radius: 10px;
            }

            .spice-card {
                min-width: 300px;
                width: 300px;
                flex: 0 0 auto;
            }

            /* Responsive Adjustments */
            @media (max-width: 768px) {
                .image-slider {
                    height: 50vh;
                    min-height: 350px;
                }

                .spice-card {
                    min-width: 260px;
                    width: 260px;
                }

                header {
                    flex-direction: column;
                    gap: 1rem;
                    padding: 1rem 2rem;
                }

                nav {
                    width: 100%;
                    justify-content: center;
                }
            }
        </style>
    </head>
    
    <body class="text-white">
        <div class="bg-particle"></div>

        <!-- Main Content - Loads immediately -->
        <div class="min-h-screen relative overflow-hidden">
            <div class="relative min-h-screen flex flex-col">
                <div class="relative w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <!-- Header -->
                    <header class="flex items-center justify-between py-6 z-50 glass-effect px-6 mt-4">
                        <div class="flex items-center">
                            <img src="{{ asset('images/spiceroot_logo.png') }}" alt="SpiceRoot" class="w-12 h-12 object-contain hover:scale-110 transition-transform sm:w-10 sm:h-10">
                            <h1 class="text-2xl font-bold text-orange-500 ml-3 sm:text-xl">SpiceRoot</h1>
                        </div>
                        <nav class="flex gap-4">
                            @if (Route::has('login'))
                                @auth
                                    @php
                                        $user = auth()->user();
                                        $dashboardUrl = match($user->role) {
                                            'seller' => route('seller.dashboard'),
                                            'buyer' => route('buyer.dashboard'),
                                            default => url('/dashboard'),
                                        };
                                    @endphp
                                    <a href="{{ $dashboardUrl }}" 
                                       class="btn-3d rounded-full px-5 py-2 text-white">
                                        Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" 
                                       class="rounded-full px-5 py-2 text-white border border-orange-500/30 hover:border-orange-500 hover:text-orange-500 transition">
                                        Sign In
                                    </a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" 
                                           class="btn-3d rounded-full px-5 py-2 text-white">
                                            Get Started
                                        </a>
                                    @endif
                                @endauth
                            @endif
                        </nav>
                    </header>

                    <!-- Main Content -->
                    <main class="py-12">
                        <!-- Image Slider -->
                        <div class="swiper image-slider mb-20">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="{{ asset('images/back2.jpg') }}" alt="Ceylon Cinnamon Field" class="w-full h-full object-cover">
                                    <div class="overlay">
                                        <h2 class="text-4xl md:text-6xl font-bold uppercase tracking-wide mb-4 text-orange-500">Ceylon Cinnamon</h2>
                                        <p class="text-lg md:text-xl max-w-lg mb-8 text-gray-300">World's finest with delicate flavor.</p>
                                        <a href="#cinnamon" class="btn-3d rounded-full px-5 py-2 text-white">Learn More</a>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{ asset('images/anju-ravindranath-Nihdo084Yos-unsplash.jpg') }}" alt="Premium Spices" class="w-full h-full object-cover">
                                    <div class="overlay">
                                        <h2 class="text-4xl md:text-6xl font-bold uppercase tracking-wide mb-4 text-orange-500">Premium Spices</h2>
                                        <p class="text-lg md:text-xl max-w-lg mb-8 text-gray-300">Authentic flavors from Sri Lanka.</p>
                                        <a href="#collection" class="btn-3d rounded-full px-5 py-2 text-white">Explore Collection</a>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{ asset('images/back3.jpg') }}" alt="Sri Lankan Spice Market" class="w-full h-full object-cover">
                                    <div class="overlay">
                                        <h2 class="text-4xl md:text-6xl font-bold uppercase tracking-wide mb-4 text-orange-500">Spice Markets</h2>
                                        <p class="text-lg md:text-xl max-w-lg mb-8 text-gray-300">Vibrant markets brimming with authentic flavors.</p>

                                    </div>
                                </div>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>



                        <!-- Premium Collection -->
                        <div id="collection" class="mb-24 pt-16">
                            <div class="text-center mb-12">
                                <!-- Removed Collection button -->
                                <h2 class="text-3xl md:text-4xl font-bold text-orange-500">Premium Collection</h2>
                                <p class="text-lg max-w-3xl mx-auto mt-4 text-gray-300">Discover our handpicked selection of the finest Sri Lankan spices.</p>
                            </div>
                            <div class="max-w-7xl mx-auto px-4">
                                <div class="relative">
                                    <div class="spice-scroll-container">
                                        <!-- Spice cards -->
                                        <div id="cinnamon" class="spice-card card-3d">
                                            <div class="w-full h-56 flex items-center justify-center">
                                                <img src="{{ asset('images/cinnamon.jpg') }}" alt="Ceylon Cinnamon" class="w-full h-full object-cover">
                                            </div>
                                            <div class="p-8">
                                                <h3 class="text-xl font-bold text-orange-500">Ceylon Cinnamon</h3>
                                                <p class="mt-3 text-gray-300">Delicate, sweet flavor for sweet and savory dishes.</p>
                                                <p class="mt-3 text-green-600 font-bold">★★★★★</p>
                                                @auth
                                                    @if(auth()->user()->role === 'buyer')
                                                        <a href="{{ route('buyer.shop') }}" class="mt-6 w-full btn-3d text-white py-3 rounded-full font-semibold text-center block">Learn More</a>
                                                    @else
                                                        <a href="{{ route('login') }}" class="mt-6 w-full btn-3d text-white py-3 rounded-full font-semibold text-center block">Learn More</a>
                                                    @endif
                                                @else
                                                    <a href="{{ route('register') }}" class="mt-6 w-full btn-3d text-white py-3 rounded-full font-semibold text-center block">Learn More</a>
                                                @endauth
                                            </div>
                                        </div>
                                        <div id="cloves" class="spice-card card-3d">
                                            <div class="w-full h-56 flex items-center justify-center">
                                                <img src="{{ asset('images/cloves.jpg') }}" alt="Cloves" class="w-full h-full object-cover">
                                            </div>
                                            <div class="p-8">
                                                <h3 class="text-xl font-bold text-orange-500">Cloves</h3>
                                                <p class="mt-3 text-gray-300">Intensely aromatic with a warm, sweet-spicy flavor.</p>
                                                <p class="mt-3 text-green-600 font-bold">★★★★☆</p>
                                                @auth
                                                    @if(auth()->user()->role === 'buyer')
                                                        <a href="{{ route('buyer.shop') }}" class="mt-6 w-full btn-3d text-white py-3 rounded-full font-semibold text-center block">Learn More</a>
                                                    @else
                                                        <a href="{{ route('login') }}" class="mt-6 w-full btn-3d text-white py-3 rounded-full font-semibold text-center block">Learn More</a>
                                                    @endif
                                                @else
                                                    <a href="{{ route('register') }}" class="mt-6 w-full btn-3d text-white py-3 rounded-full font-semibold text-center block">Learn More</a>
                                                @endauth
                                            </div>
                                        </div>
                                        <div id="turmeric" class="spice-card card-3d">
                                            <div class="w-full h-56 flex items-center justify-center">
                                                <img src="{{ asset('images/tumeric.jpeg') }}" alt="Organic Turmeric" class="w-full h-full object-cover">
                                            </div>
                                            <div class="p-8">
                                                <h3 class="text-xl font-bold text-orange-500">Organic Turmeric</h3>
                                                <p class="mt-3 text-gray-300">Bright orange-yellow with earthy flavor.</p>
                                                <p class="mt-3 text-green-600 font-bold">★★★★★</p>
                                                @auth
                                                    @if(auth()->user()->role === 'buyer')
                                                        <a href="{{ route('buyer.shop') }}" class="mt-6 w-full btn-3d text-white py-3 rounded-full font-semibold text-center block">Learn More</a>
                                                    @else
                                                        <a href="{{ route('login') }}" class="mt-6 w-full btn-3d text-white py-3 rounded-full font-semibold text-center block">Learn More</a>
                                                    @endif
                                                @else
                                                    <a href="{{ route('register') }}" class="mt-6 w-full btn-3d text-white py-3 rounded-full font-semibold text-center block">Learn More</a>
                                                @endauth
                                            </div>
                                        </div>
                                        <div id="cardamom" class="spice-card card-3d">
                                            <div class="w-full h-56 flex items-center justify-center">
                                                <img src="{{ asset('images/cardamam.jpg') }}" alt="Green Cardamom" class="w-full h-full object-cover">
                                            </div>
                                            <div class="p-8">
                                                <h3 class="text-xl font-bold text-orange-500">Green Cardamom</h3>
                                                <p class="mt-3 text-gray-300">Complex aroma with notes of citrus and mint.</p>
                                                <p class="mt-3 text-green-600 font-bold">★★★★★</p>
                                                @auth
                                                    @if(auth()->user()->role === 'buyer')
                                                        <a href="{{ route('buyer.shop') }}" class="mt-6 w-full btn-3d text-white py-3 rounded-full font-semibold text-center block">Learn More</a>
                                                    @else
                                                        <a href="{{ route('login') }}" class="mt-6 w-full btn-3d text-white py-3 rounded-full font-semibold text-center block">Learn More</a>
                                                    @endif
                                                @else
                                                    <a href="{{ route('register') }}" class="mt-6 w-full btn-3d text-white py-3 rounded-full font-semibold text-center block">Learn More</a>
                                                @endauth
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- How It Works Section -->
                        <div class="mb-24 pt-16 mt-16">
                            <div class="text-center mb-12">
                                <h2 class="text-3xl md:text-4xl font-bold text-orange-500">Your Journey to Exotic Spices</h2>
                                <p class="text-lg max-w-3xl mx-auto mt-4 text-gray-300">Follow these simple steps to explore, purchase, and enjoy the finest Sri Lankan spices.</p>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                                <div class="card-3d text-center">
                            <div class="h-40 w-full flex items-center justify-center bg-black/30">
                                <img src="{{ asset('images/login icon.jpeg') }}" alt="Sign In Icon" class="h-24 w-24 object-contain" />
                            </div>
                                    <div class="p-6">
                                        <h3 class="text-lg font-bold text-orange-500 mb-2">Sign In</h3>
                                        <p class="text-sm text-gray-300 mb-4">Access your account to start shopping.</p>
                                        <a href="{{ route('login') }}" class="btn-3d w-full text-white py-2 rounded-full text-sm">Sign In</a>
                                    </div>
                                </div>
                                <div class="card-3d text-center">
                            <div class="h-40 w-full flex items-center justify-center bg-black/30">
                                <img src="{{ asset('images/spice icon.png') }}" alt="Browse Spices Icon" class="h-24 w-24 object-contain" />
                            </div>
                                    <div class="p-6">
                                        <h3 class="text-lg font-bold text-orange-500 mb-2">Browse Spices</h3>
                                        <p class="text-sm text-gray-300 mb-4">Explore our premium collection.</p>
                                        <a href="#collection" class="text-orange-500 font-medium text-sm">Explore Now</a>
                                    </div>
                                </div>
                                <div class="card-3d text-center">
                            <div class="h-40 w-full flex items-center justify-center bg-black/30">
                                <img src="{{ asset('images/cart.png') }}" alt="Add to Cart Icon" class="h-24 w-24 object-contain" />
                            </div>
                                    <div class="p-6">
                                        <h3 class="text-lg font-bold text-orange-500 mb-2">Add to Cart</h3>
                                        <p class="text-sm text-gray-300 mb-4">Add spices to your cart.</p>
                                        <a href="#collection" class="text-orange-500 font-medium text-sm">Start Adding</a>
                                    </div>
                                </div>
                                <div class="card-3d text-center">
                            <div class="h-40 w-full flex items-center justify-center bg-black/30">
                                <img src="{{ asset('images/checkout icon.png') }}" alt="Checkout Icon" class="h-24 w-24 object-contain" />
                            </div>
                                    <div class="p-6">
                                        <h3 class="text-lg font-bold text-orange-500 mb-2">Secure Checkout</h3>
                                        <p class="text-sm text-gray-300 mb-4">Complete your purchase.</p>
                                        @auth
                                            @if(auth()->user()->role === 'buyer')
                                                <a href="{{ route('buyer.shop') }}" class="btn-3d w-full text-white py-2 rounded-full text-sm">Buy Now</a>
                                            @else
                                                <a href="{{ route('login') }}" class="btn-3d w-full text-white py-2 rounded-full text-sm">Buy Now</a>
                                            @endif
                                        @else
                                            <a href="{{ route('register') }}" class="btn-3d w-full text-white py-2 rounded-full text-sm">Buy Now</a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Why Choose SpiceHub Section -->
                        <div class="mb-24 pt-16 mt-16">
                            <div class="text-center mb-12">
                                <h2 class="text-3xl md:text-4xl font-bold text-orange-500">Why Choose SpiceHub</h2>
                                <p class="text-lg max-w-3xl mx-auto mt-4 text-gray-300">Discover why SpiceHub is your best choice for authentic Sri Lankan spices.</p>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                                <div class="card-3d text-center">
                                    <div class="p-8">
                                        <h3 class="text-xl font-bold text-orange-500 mb-3">Authentic Sourcing</h3>
                                        <p class="text-gray-300">We source directly from Sri Lankan farmers, ensuring purity and authenticity in every spice.</p>
                                    </div>
                                </div>
                                <div class="card-3d text-center">
                                    <div class="p-8">
                                        <h3 class="text-xl font-bold text-orange-500 mb-3">Unmatched Quality</h3>
                                        <p class="text-gray-300">Every batch is rigorously tested to guarantee the highest quality and flavor.</p>
                                    </div>
                                </div>
                                <div class="card-3d text-center">
                                    <div class="p-8">
                                        <h3 class="text-xl font-bold text-orange-500 mb-3">Customer Satisfaction</h3>
                                        <p class="text-gray-300">We prioritize your satisfaction with easy returns and dedicated support.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Call to Action -->
                        <div class="text-center mb-24 pt-16">
                            <div class="glass-effect p-8 rounded-xl">
                                <h2 class="text-3xl font-bold text-orange-500 mb-4">Ready to Start Your Spice Journey?</h2>
                                <p class="text-lg text-gray-300 mb-8">Join thousands of satisfied customers who trust SpiceHub.</p>
                                @auth
                                    @if(auth()->user()->role === 'buyer')
                                        <a href="{{ route('buyer.shop') }}" class="btn-3d px-8 py-4 text-white rounded-full text-lg">Start Shopping</a>
                                    @else
                                        <a href="{{ route('login') }}" class="btn-3d px-8 py-4 text-white rounded-full text-lg">Get Started</a>
                                    @endif
                                @else
                                    <a href="{{ route('register') }}" class="btn-3d px-8 py-4 text-white rounded-full text-lg">Get Started</a>
                                @endauth
                            </div>
                        </div>
                    </main>

                    <!-- Footer -->
                    <footer class="py-12 border-t border-orange-500/10 text-center text-gray-300">
                        <h3 class="text-3xl font-bold text-orange-500">SpiceHub</h3>
                        <p class="mt-3 text-lg text-gray-400">Authentic Flavors of Ceylon</p>
                        <div class="mt-6 flex justify-center space-x-6">
                            <a href="#" class="text-gray-400 hover:text-orange-500 transition duration-300">About Us</a>
                            <a href="#" class="text-gray-400 hover:text-orange-500 transition duration-300">Contact</a>
                            <a href="#" class="text-gray-400 hover:text-orange-500 transition duration-300">FAQs</a>
                        </div>
                        <p class="mt-6 text-gray-500">© 2025 SpiceHub. All rights reserved.</p>
                    </footer>
                </div>
            </div>
        </div>

        <!-- Swiper JS -->
        <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
        
        <script>
            // Simple Swiper initialization - no delays or complex animations
            document.addEventListener('DOMContentLoaded', function() {
                const imageSlider = new Swiper('.image-slider', {
                    loop: true,
                    autoplay: {
                        delay: 4000,
                        disableOnInteraction: false,
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    effect: 'fade',
                    fadeEffect: {
                        crossFade: true,
                    },
                    speed: 500,
                });

                // Simple scroll for spice collection
                const scrollContainer = document.querySelector('.spice-scroll-container');
                if (scrollContainer) {
                    // Simple scroll behavior - no complex animations
                    scrollContainer.addEventListener('wheel', function(e) {
                        e.preventDefault();
                        scrollContainer.scrollLeft += e.deltaY;
                    });
                }
            });
        </script>
    </body>
</html>
