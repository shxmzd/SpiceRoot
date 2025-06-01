<div class="min-h-screen relative" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);">
@php
    $isInWishlist = $isInWishlist ?? false;
@endphp
    <x-slot name="header">
        <div class="relative shadow-2xl border-b border-orange-500/30" style="background: linear-gradient(145deg, #2a2a2a, #1f1f1f);">
            <div class="flex items-center justify-between p-6">
                <div class="flex items-center space-x-4">
                    <div class="h-12 w-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center shadow-xl">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h3a1 1 0 110 2h-1v11a3 3 0 01-3 3H8a3 3 0 01-3-3V6H4a1 1 0 110-2h3zM9 3v1h6V3H9z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold bg-gradient-to-r from-orange-400 to-orange-600 bg-clip-text text-transparent">
                            {{ $product->name }}
                        </h2>
                        <p class="text-gray-400">Premium Spice Details</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('buyer.shop') }}" class="button-3d bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-3 px-6 rounded-full transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                        <span class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            <span>Back to Shop</span>
                        </span>
                    </a>
                    <a href="{{ route('buyer.dashboard') }}" class="button-3d bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white font-bold py-3 px-6 rounded-full transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                        Dashboard
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
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

            <!-- Product Details -->
            <div class="card-3d rounded-2xl overflow-hidden shadow-2xl border border-gray-600/30" style="background: linear-gradient(145deg, #2a2a2a, #1f1f1f);">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-8">
                    
                    <!-- Product Image -->
                    <div class="space-y-4">
                        <div class="aspect-square rounded-xl overflow-hidden border border-gray-600/30 shadow-2xl" style="background: linear-gradient(145deg, #1f1f1f, #2a2a2a);">
                            @if($product->image)
                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-400">
                                    <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Product Information -->
                    <div class="space-y-6">
                        <!-- Product Name -->
                        <h1 class="text-4xl font-bold bg-gradient-to-r from-orange-400 to-orange-600 bg-clip-text text-transparent glow">{{ $product->name }}</h1>

                        <!-- Category -->
                        <div>
                            <span class="inline-flex items-center bg-gradient-to-r from-orange-500 to-orange-600 text-white text-sm font-semibold px-4 py-2 rounded-full shadow-lg glow">
                                {{ $product->category }}
                            </span>
                        </div>

                        <!-- Price and Average Rating -->
                        <div class="flex items-center space-x-6">
                            <span class="text-4xl font-bold bg-gradient-to-r from-green-400 to-green-600 bg-clip-text text-transparent glow">{{ $product->formatted_price }}</span>
                            <div class="flex items-center">
                                @if($averageRating > 0)
                                    <span class="text-yellow-400 text-xl font-semibold mr-2 glow">{{ $averageRating }}</span>
                                    <svg class="w-6 h-6 text-yellow-400 glow" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <span class="text-gray-300 ml-2 text-sm">Average Rating</span>
                                @else
                                    <span class="text-gray-400">No ratings yet</span>
                                @endif
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="card-3d rounded-xl p-6" style="background: linear-gradient(145deg, #1f1f1f, #2a2a2a);">
                            <h3 class="text-xl font-bold bg-gradient-to-r from-orange-400 to-orange-600 bg-clip-text text-transparent mb-4">Description</h3>
                            <p class="text-gray-300 leading-relaxed">{{ $product->description }}</p>
                        </div>

                        <!-- Seller Information -->
                        <div class="card-3d rounded-xl p-6 border border-gray-600/30" style="background: linear-gradient(145deg, #1f1f1f, #2a2a2a);">
                            <h3 class="text-xl font-bold bg-gradient-to-r from-green-400 to-green-600 bg-clip-text text-transparent mb-4">Sold by</h3>
                            <div class="flex items-center space-x-4">
                                @if($product->seller->profile_photo_path)
                                    <img src="{{ Storage::url($product->seller->profile_photo_path) }}" alt="{{ $product->seller->name }}" class="w-12 h-12 rounded-full object-cover shadow-lg">
                                @else
                                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center shadow-lg">
                                        <span class="text-white font-bold text-lg">{{ substr($product->seller->name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-white font-bold text-lg">{{ $product->seller->name }}</p>
                                    <p class="text-gray-400">Premium Spice Merchant</p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="space-y-4">
                            <button 
                                wire:click="addToCart"
                                class="w-full button-3d bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-4 px-6 rounded-full transition-all duration-300 transform hover:scale-105 hover:shadow-2xl flex items-center justify-center"
                            >
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5.5M7 13l2.5 5.5m0 0L12 21m0 0l2.5-2.5M12 21l2.5-2.5"></path>
                                </svg>
                                Add to Cart
                            </button>
                            
                            <button 
                                wire:click="addToWishlist"
                                class="w-full button-3d bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold py-4 px-6 rounded-full transition-all duration-300 transform hover:scale-105 hover:shadow-2xl flex items-center justify-center {{ $isInWishlist ? 'opacity-50 cursor-not-allowed' : '' }}"
                                {{ $isInWishlist ? 'disabled' : '' }}
                            >
                                @if($isInWishlist)
                                    <svg class="w-6 h-6 mr-3 text-red-300 glow" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                    Already in Wishlist
                                @else
                                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                    Add to Wishlist
                                @endif
                            </button>
                        </div>

                        <!-- Product Details -->
                        <div class="card-3d rounded-xl p-6 border border-gray-600/30" style="background: linear-gradient(145deg, #1f1f1f, #2a2a2a);">
                            <h3 class="text-xl font-bold bg-gradient-to-r from-blue-400 to-blue-600 bg-clip-text text-transparent mb-4">Product Details</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center p-3 rounded-lg" style="background: linear-gradient(145deg, #2a2a2a, #1f1f1f);">
                                    <span class="text-gray-400 font-medium">Category:</span>
                                    <span class="text-white font-semibold">{{ $product->category }}</span>
                                </div>
                                <div class="flex justify-between items-center p-3 rounded-lg" style="background: linear-gradient(145deg, #2a2a2a, #1f1f1f);">
                                    <span class="text-gray-400 font-medium">Added:</span>
                                    <span class="text-white font-semibold">{{ $product->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="flex justify-between items-center p-3 rounded-lg" style="background: linear-gradient(145deg, #2a2a2a, #1f1f1f);">
                                    <span class="text-gray-400 font-medium">Status:</span>
                                    <span class="text-green-400 font-semibold glow">In Stock</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reviews Section (Dynamic) -->
                <div class="border-t border-gray-600/30 p-8" style="background: linear-gradient(145deg, #1f1f1f, #2a2a2a);">
                    <div class="flex items-center space-x-4 mb-8">
                        <div class="h-12 w-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-xl">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold bg-gradient-to-r from-blue-400 to-blue-600 bg-clip-text text-transparent">Customer Reviews</h3>
                    </div>
                    @if($reviews->count())
                        <div class="space-y-6">
                            @foreach($reviews as $review)
                                <div class="card-3d rounded-xl p-6 border border-gray-600/30" style="background: linear-gradient(145deg, #2a2a2a, #1f1f1f);">
                                    <div class="flex items-center space-x-4 mb-4">
                                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center shadow-lg">
                                            <span class="text-white font-bold text-lg">
                                                {{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-white font-bold text-lg">{{ $review->user->name ?? 'Unknown User' }}</p>
                                            <div class="flex items-center space-x-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-5 h-5 {{ $i <= $review->rating ? 'text-yellow-400 glow' : 'text-gray-500' }}" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-4 rounded-lg" style="background: linear-gradient(145deg, #1f1f1f, #2a2a2a);">
                                        <p class="text-gray-300 leading-relaxed">{{ $review->review_text }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="card-3d inline-block p-8 rounded-2xl">
                                <svg class="mx-auto h-16 w-16 text-orange-400 glow mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                </svg>
                                <p class="text-gray-400 text-lg">No reviews yet. Be the first to review this product!</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>