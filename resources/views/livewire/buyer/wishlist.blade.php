<div class="wishlist-container min-h-screen relative" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);">
    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div id="success-flash" class="bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg flex items-center justify-between min-w-80 transition-opacity duration-300" style="position: fixed !important; top: 20px !important; right: 20px !important; z-index: 9999 !important;">
            <span>{{ session('success') }}</span>
            <button onclick="document.getElementById('success-flash').style.display='none'" class="ml-4 text-white hover:text-gray-200 font-bold text-xl leading-none">&times;</button>
        </div>
        <script>
            setTimeout(function() {
                const successFlash = document.getElementById('success-flash');
                if (successFlash) {
                    successFlash.style.opacity = '0';
                    setTimeout(function() {
                        successFlash.style.display = 'none';
                    }, 300);
                }
            }, 4000);
        </script>
    @endif

    @if (session()->has('error'))
        <div id="error-flash" class="bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg flex items-center justify-between min-w-80 transition-opacity duration-300" style="position: fixed !important; top: 20px !important; right: 20px !important; z-index: 9999 !important;">
            <span>{{ session('error') }}</span>
            <button onclick="document.getElementById('error-flash').style.display='none'" class="ml-4 text-white hover:text-gray-200 font-bold text-xl leading-none">&times;</button>
        </div>
        <script>
            setTimeout(function() {
                const errorFlash = document.getElementById('error-flash');
                if (errorFlash) {
                    errorFlash.style.opacity = '0';
                    setTimeout(function() {
                        errorFlash.style.display = 'none';
                    }, 300);
                }
            }, 4000);
        </script>
    @endif

    @if (session()->has('info'))
        <div id="info-flash" class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow-lg flex items-center justify-between min-w-80 transition-opacity duration-300" style="position: fixed !important; top: 20px !important; right: 20px !important; z-index: 9999 !important;">
            <span>{{ session('info') }}</span>
            <button onclick="document.getElementById('info-flash').style.display='none'" class="ml-4 text-white hover:text-gray-200 font-bold text-xl leading-none">&times;</button>
        </div>
        <script>
            setTimeout(function() {
                const infoFlash = document.getElementById('info-flash');
                if (infoFlash) {
                    infoFlash.style.opacity = '0';
                    setTimeout(function() {
                        infoFlash.style.display = 'none';
                    }, 300);
                }
            }, 4000);
        </script>
    @endif

    <!-- Header -->
    <div class="py-8 px-4 md:px-8">
        <div class="max-w-6xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-bold text-orange-500 text-center mb-8 glow">Your Wishlist</h1>
        </div>
    </div>

    <!-- Main Content -->
    <div class="px-4 md:px-8 pb-16">
        <div class="max-w-6xl mx-auto">

            @if($wishlistItems->count() > 0)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- Wishlist Items Section -->
                    <div class="lg:col-span-2">
                        <div class="space-y-6">
                            @foreach($wishlistItems as $item)
                                @if($item->product)
                                    <div class="card-3d rounded-xl p-6">
                                        <div class="flex items-center space-x-6">
                                            <!-- Product Image -->
                                            <div class="flex-shrink-0">
                                                <div class="w-20 h-20 bg-gray-700 rounded-lg overflow-hidden">
                                                    @if($item->product->image)
                                                        <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                             alt="{{ $item->product->name }}" 
                                                             class="w-full h-full object-cover">
                                                    @else
                                                        <div class="flex items-center justify-center h-full text-orange-400">
                                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Product Details -->
                                            <div class="flex-1">
                                                <h3 class="text-xl font-bold text-orange-500 mb-2">{{ $item->product->name }}</h3>
                                                <p class="text-gray-300 text-sm mb-3">{{ Str::limit($item->product->description, 80) }}</p>
                                                <p class="text-green-400 font-semibold">Rs. {{ number_format($item->product->price, 2) }}</p>
                                                
                                                <!-- Category Badge -->
                                                <div class="mt-2">
                                                    <span class="inline-flex items-center bg-gradient-to-r from-orange-500 to-orange-600 text-white text-xs font-semibold px-3 py-1 rounded-full shadow-lg glow">
                                                        {{ $item->product->category }}
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Action Buttons -->
                                            <div class="flex flex-col space-y-3">
                                                <!-- Add to Cart Button -->
                                                <button 
                                                    wire:click="addToCart('{{ $item->product->_id }}')"
                                                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold transition duration-200 button-3d flex items-center justify-center">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.293 2.293A1 1 0 005 16h9m-9 0a2 2 0 104 0M19 16a2 2 0 11-4 0"></path>
                                                    </svg>
                                                    Add to Cart
                                                </button>

                                                <!-- Remove Button -->
                                                <button 
                                                    wire:click="removeFromWishlist('{{ $item->product->_id }}')"
                                                    onclick="return confirm('Are you sure you want to remove this item from your wishlist?')"
                                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-semibold transition duration-200 button-3d flex items-center justify-center">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                    Remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Wishlist Summary -->
                    <div class="lg:col-span-1">
                        <div class="card-3d rounded-xl p-6 sticky top-8">
                            <h2 class="text-2xl font-bold text-orange-500 mb-6">Wishlist Summary</h2>
                            
                            <div class="space-y-4 mb-6">
                                <div class="flex justify-between text-gray-300">
                                    <span>Total Items:</span>
                                    <span>{{ $wishlistItems->count() }}</span>
                                </div>
                                <div class="flex justify-between text-gray-300">
                                    <span>Total Value:</span>
                                    <span class="text-green-400 glow">Rs. {{ number_format($wishlistItems->sum(function($item) { return $item->product ? $item->product->price : 0; }), 2) }}</span>
                                </div>
                                <hr class="border-gray-600">
                                <div class="text-sm text-gray-400">
                                    <p>💝 Save your favorite spices</p>
                                    <p>🛒 Move items to cart easily</p>
                                    <p>💰 Track price changes</p>
                                </div>
                            </div>

                            <button 
                                wire:click="continueShopping"
                                class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-full transition duration-300 button-3d sparkle mb-4">
                                Continue Shopping
                            </button>

                            <a 
                                href="{{ route('buyer.cart') }}"
                                class="w-full bg-orange-600 hover:bg-orange-700 text-white font-semibold py-3 px-6 rounded-full transition duration-300 button-3d block text-center">
                                View Cart
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty Wishlist -->
                <div class="text-center py-20">
                    <div class="card-3d inline-block p-8 rounded-2xl mb-8">
                        <svg class="mx-auto h-24 w-24 text-orange-400 glow mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold text-orange-500 glow mb-4">Your Wishlist is Empty</h3>
                    <p class="text-gray-400 text-lg mb-8">Start adding your favorite spices and herbs to your wishlist!</p>
                    <button 
                        wire:click="continueShopping"
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-full transition duration-300 button-3d sparkle">
                        Start Shopping
                    </button>
                </div>
            @endif
        </div>
    </div>

    <style scoped>
        /* Wishlist specific styles - scoped to prevent navbar interference */
        .wishlist-container .glow {
            text-shadow: 0 0 10px rgba(249, 115, 22, 0.5);
        }
        
        /* 3D Card Effects */
        .wishlist-container .card-3d {
            background: linear-gradient(145deg, #2a2a2a, #1f1f1f);
            border: 1px solid rgba(156, 163, 175, 0.2);
            box-shadow: 
                0 4px 8px rgba(0, 0, 0, 0.3),
                0 0 20px rgba(249, 115, 22, 0.1);
            transform-style: preserve-3d;
            transition: all 0.3s ease;
        }
        
        .wishlist-container .card-3d:hover {
            transform: rotateY(5deg) rotateX(5deg) translateZ(20px);
            box-shadow: 
                0 8px 25px rgba(0, 0, 0, 0.4),
                0 0 40px rgba(249, 115, 22, 0.2);
        }
        
        /* Button 3D Effects - scoped to wishlist container only */
        .wishlist-container .button-3d {
            background: linear-gradient(145deg, #f97316, #ea580c);
            border: none;
            box-shadow: 
                0 4px 8px rgba(0, 0, 0, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            transform-style: preserve-3d;
            transition: all 0.2s ease;
        }
        
        .wishlist-container .button-3d:hover {
            transform: translateY(-2px);
            box-shadow: 
                0 6px 12px rgba(0, 0, 0, 0.4),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }
        
        .wishlist-container .button-3d:active {
            transform: translateY(1px);
            box-shadow: 
                0 2px 4px rgba(0, 0, 0, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }

        /* Sparkle effect for buttons */
        .wishlist-container .sparkle {
            background: linear-gradient(45deg, #10b981, #059669, #10b981);
            background-size: 200% 200%;
            animation: sparkle 2s ease-in-out infinite;
        }

        @keyframes sparkle {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
    </style>
</div>