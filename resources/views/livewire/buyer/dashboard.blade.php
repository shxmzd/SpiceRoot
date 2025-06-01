@php
    use Illuminate\Support\Facades\Storage;
@endphp
<div>
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

    <!-- Hero Section -->
    <header class="hero-bg h-screen flex items-center justify-center text-center transform translateZ(40px)">
        <div class="relative z-10 px-4">
            <h1 class="text-5xl md:text-7xl font-bold text-orange-500 glow">SpiceRoot</h1>
            <p class="mt-4 text-xl md:text-2xl text-gray-200">Unleash a Symphony of Flavors with Our Premium Spices</p>
            <button wire:click="discoverNow" class="mt-8 inline-block bg-orange-600 button-3d text-white py-4 px-8 rounded-full text-lg font-semibold sparkle">
                Discover Now
            </button>
        </div>
    </header>

    <!-- Signature Collection -->
    <section class="py-16 px-4 md:px-8">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl font-bold text-orange-500 glow text-center mb-12">Our Signature Collection</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach($signatureCollection as $collection)
                <div class="card-3d rounded-xl cursor-pointer" wire:click="exploreCategory('{{ $collection['category'] }}')">
                    <img src="{{ asset('images/' . $collection['image']) }}" alt="{{ $collection['name'] }}" class="w-full h-56 object-cover transform translateZ(20px)" />
                    <div class="p-8 transform translateZ(30px)">
                        <h3 class="text-3xl font-bold text-orange-500 glow">{{ $collection['name'] }}</h3>
                        <p class="mt-3 text-gray-300 text-lg">{{ $collection['description'] }}</p>
                        <button class="mt-6 w-full bg-green-600 button-3d text-white py-3 rounded-full font-semibold text-lg">
                            Explore Collection
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Recently Viewed Spices -->
    @if(count($recentlyViewedProducts) > 0)
    <section class="py-16 px-4 md:px-8 transform translateZ(20px)">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl font-bold text-orange-500 glow text-center mb-12">Recently Viewed Spices & Herbs</h2>
            <div class="recently-viewed-container flex space-x-8 overflow-x-auto pb-6 snap-x snap-mandatory">
                @foreach($recentlyViewedProducts as $product)
                <div class="card-3d flex-none w-80 snap-center cursor-pointer hover:scale-105 transition-all duration-300">
                    <div class="relative overflow-hidden rounded-t-xl transform translateZ(20px)">
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-48 object-cover transform translateZ(10px) hover:scale-110 transition-transform duration-300" />
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center">
                                <svg class="w-20 h-20 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                        <div class="absolute top-3 right-3 bg-orange-600 text-white px-2 py-1 rounded-full text-xs font-semibold glow">
                            Recently Viewed
                        </div>
                    </div>
                    <div class="p-6 transform translateZ(30px)">
                        <h3 class="text-2xl font-bold text-orange-500 glow mb-2">{{ $product->name }}</h3>
                        <p class="text-gray-300 text-base leading-relaxed mb-3">{{ Str::limit($product->description, 80) }}</p>
                        <div class="flex items-center justify-between mb-4">
                            <p class="text-green-400 font-bold text-xl glow">{{ $product->formatted_price }}</p>
                            <div class="flex items-center text-orange-400">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-sm">Premium</span>
                            </div>
                        </div>
                        
                        <!-- Enhanced buttons with theme styling -->
                        <div class="flex space-x-3 mt-4 relative z-50">
                            <button 
                                wire:click="addToCart('{{ $product->_id }}')"
                                wire:loading.attr="disabled"
                                wire:loading.class="opacity-50"
                                type="button"
                                style="pointer-events: auto !important;"
                                class="flex-1 bg-green-600 button-3d text-white py-3 px-4 rounded-full font-semibold text-base sparkle hover:bg-green-700 focus:bg-green-700 active:bg-green-800 transition duration-200 border-none outline-none cursor-pointer">
                                <span wire:loading.remove wire:target="addToCart('{{ $product->_id }}')">Add to Cart</span>
                                <span wire:loading wire:target="addToCart('{{ $product->_id }}')">Adding...</span>
                            </button>
                            <button 
                                wire:click="addToWishlist('{{ $product->_id }}')"
                                wire:loading.attr="disabled"
                                wire:loading.class="opacity-50"
                                type="button"
                                style="pointer-events: auto !important;"
                                class="px-4 bg-orange-600 button-3d text-white py-3 rounded-full font-semibold text-xl hover:bg-orange-700 focus:bg-orange-700 active:bg-orange-800 transition duration-200 border-none outline-none cursor-pointer glow">
                                <span wire:loading.remove wire:target="addToWishlist('{{ $product->_id }}')">♡</span>
                                <span wire:loading wire:target="addToWishlist('{{ $product->_id }}')">...</span>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Scroll indicator -->
            <div class="flex justify-center mt-6">
                <div class="flex space-x-2">
                    <div class="w-2 h-2 bg-orange-500 rounded-full animate-pulse"></div>
                    <div class="w-2 h-2 bg-orange-400 rounded-full animate-pulse" style="animation-delay: 0.2s"></div>
                    <div class="w-2 h-2 bg-orange-300 rounded-full animate-pulse" style="animation-delay: 0.4s"></div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Call to Action -->
    <section class="py-16 px-4 md:px-8 bg-gray-900 transform translateZ(30px)">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl font-bold text-orange-500 glow">Elevate Your Culinary Journey</h2>
            <p class="mt-4 text-xl text-gray-300">Explore our curated selection of spices and herbs, crafted to inspire your kitchen creations.</p>
            <button wire:click="discoverNow" class="mt-8 inline-block bg-orange-600 button-3d text-white py-4 px-8 rounded-full text-lg font-semibold sparkle">
                Shop All Spices
            </button>
        </div>
    </section>
</div>