<div class="min-h-screen relative overflow-hidden" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);">
    <x-slot name="header">
        <div class="relative shadow-2xl border-b border-orange-500/30" style="background: linear-gradient(145deg, #2a2a2a, #1f1f1f);">
            <div class="flex items-center justify-between p-6">
                <div class="flex items-center space-x-4">
                    <div class="h-12 w-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center shadow-xl">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <h2 class="font-bold text-3xl bg-gradient-to-r from-orange-400 to-orange-600 bg-clip-text text-transparent">
                        {{ __('SpiceRoot Shop') }}
                    </h2>
                </div>
                <a href="{{ route('dashboard') }}" class="group relative bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-3 px-6 rounded-full transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                    <span class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span>Dashboard</span>
                    </span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="relative z-10 py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Success Messages -->
            @if (session()->has('success'))
                <div class="mb-8 bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-4 rounded-xl shadow-2xl border border-green-400/50 transform hover:scale-105 transition-all duration-300" role="alert">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="font-semibold">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Hero Section -->
            <div class="text-center mb-12">
                <h1 class="text-5xl md:text-6xl font-bold bg-gradient-to-r from-orange-400 via-orange-500 to-orange-600 bg-clip-text text-transparent mb-4">
                    Discover Premium Spices
                </h1>
                <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                    Explore our curated collection of the world's finest spices and herbs
                </p>
            </div>

            <!-- Search and Filter Section -->
            <div class="rounded-2xl shadow-2xl p-8 mb-12 border border-gray-600/30" style="background: linear-gradient(145deg, #2a2a2a, #1f1f1f);">
                <!-- Search Bar -->
                <div class="mb-8">
                    <div class="relative max-w-2xl mx-auto">
                        <div class="absolute inset-0 bg-gradient-to-r from-orange-500/20 to-green-500/20 rounded-full blur-lg"></div>
                        <div class="relative">
                            <input 
                                type="text" 
                                wire:model.live.debounce.300ms="search"
                                placeholder="Explore Exquisite Spices & Herbs..."
                                class="w-full px-8 py-5 pr-16 text-white rounded-full border border-gray-600/50 focus:border-orange-500 focus:ring-4 focus:ring-orange-500/25 transition-all duration-300 text-lg placeholder-gray-400 shadow-2xl"
                                style="background: linear-gradient(145deg, #1f1f1f, #2a2a2a);"
                            >
                            <div class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-gradient-to-r from-orange-500 to-orange-600 rounded-full p-3 shadow-lg hover:shadow-xl transition-all duration-300 cursor-pointer">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <!-- Category Filter -->
                    <div class="group">
                        <label class="block text-sm font-semibold text-gray-300 mb-3 group-hover:text-orange-400 transition-colors duration-300">Category</label>
                        <div class="relative">
                            <select 
                                wire:model.live="selectedCategory"
                                class="w-full px-5 py-4 text-white rounded-xl border border-gray-600/50 focus:border-orange-500 focus:ring-4 focus:ring-orange-500/25 transition-all duration-300 appearance-none cursor-pointer shadow-lg dropdown-select"
                                style="background: linear-gradient(145deg, #1f1f1f, #2a2a2a);"
                            >
                                <option value="" class="dropdown-option">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" class="dropdown-option">{{ $category }}</option>
                                @endforeach
                            </select>
                            <div class="absolute right-4 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Price Range Filter -->
                    <div class="group">
                        <label class="block text-sm font-semibold text-gray-300 mb-3 group-hover:text-orange-400 transition-colors duration-300">Price Range</label>
                        <div class="relative">
                            <select 
                                wire:model.live="selectedPriceRange"
                                class="w-full px-5 py-4 text-white rounded-xl border border-gray-600/50 focus:border-orange-500 focus:ring-4 focus:ring-orange-500/25 transition-all duration-300 appearance-none cursor-pointer shadow-lg"
                                style="background: linear-gradient(145deg, #1f1f1f, #2a2a2a);"
                            >
                                <option value="">All Prices</option>
                                @foreach($priceRanges as $key => $range)
                                    <option value="{{ $key }}">{{ $range }}</option>
                                @endforeach
                            </select>
                            <div class="absolute right-4 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Sort By -->
                    <div class="group">
                        <label class="block text-sm font-semibold text-gray-300 mb-3 group-hover:text-orange-400 transition-colors duration-300">Sort By</label>
                        <div class="relative">
                            <select 
                                wire:model.live="sortBy"
                                class="w-full px-5 py-4 text-white rounded-xl border border-gray-600/50 focus:border-orange-500 focus:ring-4 focus:ring-orange-500/25 transition-all duration-300 appearance-none cursor-pointer shadow-lg"
                                style="background: linear-gradient(145deg, #1f1f1f, #2a2a2a);"
                            >
                                @foreach($sortOptions as $key => $option)
                                    <option value="{{ $key }}">{{ $option }}</option>
                                @endforeach
                            </select>
                            <div class="absolute right-4 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Clear Filters -->
                    <div class="flex items-end">
                        <button 
                            wire:click="clearFilters"
                            class="w-full bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-2xl flex items-center justify-center space-x-2 group"
                        >
                            <svg class="w-5 h-5 group-hover:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            <span>Clear</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            @if($products->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 mb-12">
                    @foreach($products as $product)
                        <div class="card-3d rounded-xl cursor-pointer transform hover:scale-105 transition-all duration-300">
                            
                            <!-- Product Image -->
                            
                            <div class="relative overflow-hidden rounded-t-xl transform translateZ(20px)" wire:click="$dispatch('navigate', '{{ route('buyer.product.details', $product->_id) }}')">
                                @if($product->image)
                                    <img src="{{ Storage::url($product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-56 object-cover transform translateZ(10px) hover:scale-110 transition-transform duration-300" />
                                @else
                                    <div class="w-full h-56 bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center">
                                        <svg class="w-20 h-20 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                
                                <!-- Wishlist Heart -->
                                <button 
                                    wire:click.stop="addToWishlist('{{ $product->_id }}')"
                                    class="absolute top-3 right-3 p-2 bg-black/50 backdrop-blur-sm rounded-full hover:bg-red-500/80 transition-all duration-300 transform hover:scale-110 z-10"
                                >
                                    @if(in_array($product->_id, $userWishlistProductIds))
                                        <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-white hover:text-red-400 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                    @endif
                                </button>
                            </div>

                            <div class="p-6 transform translateZ(30px)">
                                <!-- Product Name -->
                                <h3 class="text-2xl font-bold text-orange-500 glow mb-2 cursor-pointer hover:text-orange-400 transition-colors duration-300" 
                                    wire:click="$dispatch('navigate', '{{ route('buyer.product.details', $product->_id) }}')">
                                    {{ $product->name }}
                                </h3>

                                <!-- Description Preview -->
                                <p class="text-gray-300 text-base leading-relaxed mb-3">{{ Str::limit($product->description, 80) }}</p>

                                <!-- Price and Rating -->
                                <div class="flex items-center justify-between mb-4">
                                    <p class="text-green-400 font-bold text-xl glow">{{ $product->formatted_price }}</p>
                                    @if(isset($product->average_rating) && $product->average_rating > 0)
                                        <div class="flex items-center text-orange-400">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                            <span class="text-sm">{{ $product->average_rating }}</span>
                                        </div>
                                    @else
                                        <div class="flex items-center text-orange-400">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                            <span class="text-sm">Premium</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Category Badge -->
                                <div class="mb-4">
                                    <span class="inline-flex items-center bg-gradient-to-r from-orange-500 to-orange-600 text-white text-xs font-semibold px-3 py-1 rounded-full shadow-lg glow">
                                        {{ $product->category }}
                                    </span>
                                </div>
                                
                                <!-- Action Button -->
                                <button 
                                    wire:click="addToCart('{{ $product->_id }}')"
                                    wire:loading.attr="disabled"
                                    wire:loading.class="opacity-50"
                                    type="button"
                                    class="w-full bg-green-600 button-3d text-white py-3 px-4 rounded-full font-semibold text-base sparkle hover:bg-green-700 focus:bg-green-700 active:bg-green-800 transition duration-200 border-none outline-none cursor-pointer">
                                    <span wire:loading.remove wire:target="addToCart('{{ $product->_id }}')">Add to Cart</span>
                                    <span wire:loading wire:target="addToCart('{{ $product->_id }}')">Adding...</span>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12 flex justify-center">
                    <div class="rounded-2xl p-6 border border-gray-600/30" style="background: linear-gradient(145deg, #2a2a2a, #1f1f1f);">
                        {{ $products->links() }}
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-20">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-orange-500/10 to-green-500/10 rounded-full blur-3xl"></div>
                        <div class="relative rounded-2xl p-12 border border-gray-600/30 max-w-lg mx-auto" style="background: linear-gradient(145deg, #2a2a2a, #1f1f1f);">
                            <div class="mb-6">
                                <svg class="mx-auto h-24 w-24 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-white mb-4">No products found</h3>
                            <p class="text-gray-300 mb-6 leading-relaxed">
                                @if($search || $selectedCategory || $selectedPriceRange)
                                    We couldn't find any products matching your criteria. Try adjusting your search or filter settings.
                                @else
                                    No products are currently available in our collection.
                                @endif
                            </p>
                            @if($search || $selectedCategory || $selectedPriceRange)
                                <button wire:click="clearFilters" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-2xl space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    <span>Clear all filters</span>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Navigation Script -->
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('navigate', (url) => {
                window.location.href = url;
            });
        });
    </script>

    <!-- Custom Styles -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        .animate-blob {
            animation: blob 7s infinite;
        }
        
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        
        .animation-delay-4000 {
            animation-delay: 4s;
        }
        
        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }
            33% {
                transform: translate(30px, -50px) scale(1.1);
            }
            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }
        
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #1f2937;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #f97316, #ea580c);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #ea580c, #dc2626);
        }
        
        /* Dropdown Options Styling */
        select option {
            background: #1f1f1f !important;
            color: #ffffff !important;
            padding: 12px !important;
            border: none !important;
            font-weight: 500 !important;
        }
        
        select option:hover {
            background: #2a2a2a !important;
            color: #f97316 !important;
        }
        
        select option:checked {
            background: linear-gradient(145deg, #f97316, #ea580c) !important;
            color: #ffffff !important;
        }
        
        select option:selected {
            background: linear-gradient(145deg, #f97316, #ea580c) !important;
            color: #ffffff !important;
        }
        
        /* Enhanced focus styles */
        select:focus,
        input:focus {
            outline: none;
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.25);
            border-color: #f97316;
        }
        
        /* Card hover effects */
        .group:hover .group-hover\:scale-110 {
            transform: scale(1.1);
        }
        
        .group:hover .group-hover\:rotate-180 {
            transform: rotate(180deg);
        }
        
        /* Glow effect */
        .glow {
            text-shadow: 0 0 10px rgba(249, 115, 22, 0.5);
        }
        
        /* 3D Card Effects */
        .card-3d {
            background: linear-gradient(145deg, #2a2a2a, #1f1f1f);
            border: 1px solid rgba(156, 163, 175, 0.2);
            box-shadow: 
                0 4px 8px rgba(0, 0, 0, 0.3),
                0 0 20px rgba(249, 115, 22, 0.1);
            transform-style: preserve-3d;
            transition: all 0.3s ease;
        }
        
        .card-3d:hover {
            transform: rotateY(5deg) rotateX(5deg) translateZ(20px);
            box-shadow: 
                0 8px 25px rgba(0, 0, 0, 0.4),
                0 0 40px rgba(249, 115, 22, 0.2);
        }
        
        /* Button 3D Effects */
        .button-3d {
            background: linear-gradient(145deg, #f97316, #ea580c);
            border: none;
            box-shadow: 
                0 4px 8px rgba(0, 0, 0, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            transform-style: preserve-3d;
            transition: all 0.2s ease;
        }
        
        .button-3d:hover {
            transform: translateY(-2px);
            box-shadow: 
                0 6px 12px rgba(0, 0, 0, 0.4),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }
        
        .button-3d:active {
            transform: translateY(1px);
            box-shadow: 
                0 2px 4px rgba(0, 0, 0, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }
    </style>
</div>