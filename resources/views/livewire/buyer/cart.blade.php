@php
    use Illuminate\Support\Facades\Storage;
@endphp

<div class="min-h-screen relative" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);">
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
            <h1 class="text-4xl md:text-5xl font-bold text-orange-500 text-center mb-8 glow">Your Cart</h1>
        </div>
    </div>

    <!-- Main Content -->
    <div class="px-4 md:px-8 pb-16">
        <div class="max-w-6xl mx-auto">
            @if($cartItems->count() > 0)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- Cart Items Section -->
                    <div class="lg:col-span-2">
                        <div class="space-y-6">
                            @foreach($cartItems as $item)
                                @if($item->product)
                                    <div class="card-3d rounded-xl p-6">
                                        <div class="flex items-center space-x-6">
                                            <!-- Product Image -->
                                            <div class="flex-shrink-0">
                                                <div class="w-20 h-20 bg-gray-700 rounded-lg overflow-hidden">
                                                    @if($item->product->image)
                                                        <img src="{{ Storage::url($item->product->image) }}" 
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
                                                <p class="text-green-400 font-semibold">Rs. {{ number_format($item->price_at_time, 2) }} x {{ $item->quantity }} = Rs. {{ number_format($item->subtotal, 2) }}</p>
                                            </div>

                                            <!-- Quantity Controls with orange border -->
                                            <div class="flex items-center space-x-3">
                                                <input 
                                                    type="number" 
                                                    value="{{ $item->quantity }}"
                                                    wire:change="updateQuantity('{{ $item->_id }}', $event.target.value)"
                                                    class="w-16 px-3 py-2 bg-gray-700 text-white text-center rounded border-2 border-orange-500 focus:border-orange-400 focus:ring-2 focus:ring-orange-500"
                                                    min="1"
                                                >
                                            </div>

                                            <!-- Remove Button -->
                                            <button 
                                                wire:click="removeItem('{{ $item->_id }}')"
                                                onclick="return confirm('Are you sure you want to remove this item from your cart?')"
                                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold transition duration-200 button-3d">
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="card-3d rounded-xl p-6 sticky top-8">
                            <h2 class="text-2xl font-bold text-orange-500 mb-6">Order Summary</h2>
                            
                            <div class="space-y-4 mb-6">
                                <div class="flex justify-between text-gray-300">
                                    <span>Subtotal:</span>
                                    <span>Rs. {{ number_format($cartSummary['subtotal'] ?? 0, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-gray-300">
                                    <span>Shipping:</span>
                                    <span>Rs. {{ number_format($cartSummary['shipping'] ?? 500, 2) }}</span>
                                </div>
                                <hr class="border-gray-600">
                                <div class="flex justify-between text-xl font-bold">
                                    <span class="text-white">Total:</span>
                                    <span class="text-green-400 glow">Rs. {{ number_format($cartSummary['total'] ?? 0, 2) }}</span>
                                </div>
                            </div>

                            <button 
                                wire:click="proceedToCheckout"
                                class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-full transition duration-300 button-3d sparkle mb-4">
                                Proceed to Checkout
                            </button>

                            <button 
                                wire:click="continueShopping"
                                class="w-full bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-6 rounded-full transition duration-300 button-3d">
                                Continue Shopping
                            </button>
                        </div>
                    </div>
                </div>

            @else
                <!-- Empty Cart -->
                <div class="text-center py-20">
                    <div class="card-3d inline-block p-8 rounded-2xl mb-8">
                        <svg class="mx-auto h-24 w-24 text-orange-400 glow mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.293 2.293A1 1 0 005 16h9m-9 0a2 2 0 104 0M19 16a2 2 0 11-4 0" />
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold text-orange-500 glow mb-4">Your Cart is Empty</h3>
                    <p class="text-gray-400 text-lg mb-8">Start adding some delicious spices and herbs to your cart!</p>
                    <button 
                        wire:click="continueShopping"
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-full transition duration-300 button-3d sparkle">
                        Start Shopping
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>