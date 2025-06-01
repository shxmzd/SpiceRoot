<div class="min-h-screen relative" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Checkout') }}
            </h2>
            <a href="{{ route('buyer.cart') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                Back to Cart
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Success/Error Messages -->
            @if (session()->has('success'))
                <div class="mb-6 bg-green-600 text-white px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-6 bg-red-600 text-white px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Checkout Content -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <!-- Left Column: Delivery Information & Payment -->
                <div class="space-y-8">
                    
                    <!-- Delivery Information -->
                    <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                        <div class="p-6 border-b border-gray-700">
                            <h3 class="text-2xl font-bold text-orange-500 flex items-center">
                                <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Delivery Information
                            </h3>
                        </div>

                        <div class="p-6">
                            <form wire:submit.prevent="processPayment" id="checkout-form">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    
                                    <!-- Full Name -->
                                    <div class="md:col-span-1">
                                        <label for="full_name" class="block text-sm font-medium text-gray-300 mb-2">Full Name *</label>
                                        <input 
                                            type="text" 
                                            id="full_name"
                                            wire:model="full_name"
                                            class="w-full px-4 py-3 bg-gray-700 text-white rounded-lg border border-gray-600 focus:border-orange-500 focus:ring-orange-500 transition duration-200"
                                            placeholder="Enter your full name"
                                        >
                                        @error('full_name') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="md:col-span-1">
                                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email Address *</label>
                                        <input 
                                            type="email" 
                                            id="email"
                                            wire:model="email"
                                            class="w-full px-4 py-3 bg-gray-700 text-white rounded-lg border border-gray-600 focus:border-orange-500 focus:ring-orange-500 transition duration-200"
                                            placeholder="Enter your email"
                                        >
                                        @error('email') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Phone -->
                                    <div class="md:col-span-1">
                                        <label for="phone" class="block text-sm font-medium text-gray-300 mb-2">Phone Number *</label>
                                        <input 
                                            type="tel" 
                                            id="phone"
                                            wire:model="phone"
                                            class="w-full px-4 py-3 bg-gray-700 text-white rounded-lg border border-gray-600 focus:border-orange-500 focus:ring-orange-500 transition duration-200"
                                            placeholder="Enter your phone number"
                                        >
                                        @error('phone') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Street Address -->
                                    <div class="md:col-span-2">
                                        <label for="street_address" class="block text-sm font-medium text-gray-300 mb-2">Street Address *</label>
                                        <input 
                                            type="text" 
                                            id="street_address"
                                            wire:model="street_address"
                                            class="w-full px-4 py-3 bg-gray-700 text-white rounded-lg border border-gray-600 focus:border-orange-500 focus:ring-orange-500 transition duration-200"
                                            placeholder="Enter your street address"
                                        >
                                        @error('street_address') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- City -->
                                    <div class="md:col-span-1">
                                        <label for="city" class="block text-sm font-medium text-gray-300 mb-2">City *</label>
                                        <input 
                                            type="text" 
                                            id="city"
                                            wire:model="city"
                                            class="w-full px-4 py-3 bg-gray-700 text-white rounded-lg border border-gray-600 focus:border-orange-500 focus:ring-orange-500 transition duration-200"
                                            placeholder="Enter your city"
                                        >
                                        @error('city') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Postal Code -->
                                    <div class="md:col-span-1">
                                        <label for="postal_code" class="block text-sm font-medium text-gray-300 mb-2">Postal Code *</label>
                                        <input 
                                            type="text" 
                                            id="postal_code"
                                            wire:model="postal_code"
                                            class="w-full px-4 py-3 bg-gray-700 text-white rounded-lg border border-gray-600 focus:border-orange-500 focus:ring-orange-500 transition duration-200"
                                            placeholder="Enter postal code"
                                        >
                                        @error('postal_code') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Delivery Notes -->
                                    <div class="md:col-span-2">
                                        <label for="delivery_notes" class="block text-sm font-medium text-gray-300 mb-2">Delivery Notes (Optional)</label>
                                        <textarea 
                                            id="delivery_notes"
                                            wire:model="delivery_notes"
                                            rows="3"
                                            class="w-full px-4 py-3 bg-gray-700 text-white rounded-lg border border-gray-600 focus:border-orange-500 focus:ring-orange-500 transition duration-200"
                                            placeholder="Any special delivery instructions..."
                                        ></textarea>
                                        @error('delivery_notes') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                        <div class="p-6 border-b border-gray-700">
                            <h3 class="text-2xl font-bold text-orange-500 flex items-center">
                                <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                                Payment Information
                            </h3>
                        </div>

                        <div class="p-6">
                            <!-- Test Card Info -->
                            <div class="mb-4 p-4 bg-blue-900 rounded-lg">
                                <h4 class="text-blue-300 font-semibold mb-2">Test Mode - Use These Card Numbers:</h4>
                                <div class="text-blue-200 text-sm space-y-1">
                                    <p><strong>Success:</strong> 4242 4242 4242 4242</p>
                                    <p><strong>Declined:</strong> 4000 0000 0000 0002</p>
                                    <p><strong>Expiry:</strong> Any future date (12/25) | <strong>CVC:</strong> Any 3 digits (123)</p>
                                </div>
                            </div>

                            <!-- Stripe Elements will be inserted here -->
                            <div id="card-element" class="w-full p-4 bg-gray-700 rounded-lg border border-gray-600">
                                <!-- Stripe Elements Placeholder -->
                            </div>
                            <div id="card-errors" role="alert" class="text-red-500 text-sm mt-2"></div>
                            
                            <!-- Payment Button -->
                            <button 
                                type="submit" 
                                form="checkout-form"
                                id="submit-payment"
                                class="w-full mt-6 bg-green-600 hover:bg-green-700 text-white font-bold py-4 px-6 rounded-lg transition duration-200 flex items-center justify-center text-lg"
                                disabled
                            >
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2-2v6a2 2 0 002 2z"></path>
                                </svg>
                                <span id="button-text">Complete Order - USD ${{ number_format($cartSummary['total'] ?? 0, 2) }}</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden sticky top-8">
                        <div class="p-6 border-b border-gray-700">
                            <h3 class="text-2xl font-bold text-orange-500">Order Summary</h3>
                        </div>

                        <div class="p-6">
                            <!-- Order Items -->
                            <div class="space-y-4 mb-6">
                                @foreach($cartItems as $item)
                                    @if($item->product)
                                        <div class="flex items-center space-x-4">
                                            <div class="w-16 h-16 bg-gray-700 rounded-lg overflow-hidden flex-shrink-0">
                                                @if($item->product->image)
                                                    <img src="{{ Storage::url($item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="flex items-center justify-center h-full text-gray-400">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="text-white font-medium">{{ $item->product->name }}</h4>
                                                <p class="text-gray-400 text-sm">Qty: {{ $item->quantity }}</p>
                                            </div>
                                            <div class="text-green-400 font-semibold">
                                                USD ${{ number_format($item->subtotal, 2) }}
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            <!-- Order Totals -->
                            <div class="space-y-3 border-t border-gray-700 pt-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-300">Subtotal:</span>
                                    <span class="text-white font-semibold">USD ${{ number_format($cartSummary['subtotal'] ?? 0, 2) }}</span>
                                </div>
                                
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-300">Shipping:</span>
                                    <span class="text-white font-semibold">USD ${{ number_format($cartSummary['shipping'] ?? 0, 2) }}</span>
                                </div>

                                <div class="flex justify-between items-center text-lg border-t border-gray-600 pt-3">
                                    <span class="text-white font-bold">Total:</span>
                                    <span class="text-green-400 font-bold">USD ${{ number_format($cartSummary['total'] ?? 0, 2) }}</span>
                                </div>
                            </div>

                            <!-- Security Badge -->
                            <div class="mt-6 p-4 bg-gray-700 rounded-lg">
                                <div class="flex items-center text-green-400 mb-2">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2-2v6a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="font-semibold">Secure Payment</span>
                                </div>
                                <p class="text-gray-300 text-sm">Your payment information is encrypted and secure. We use Stripe for payment processing.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stripe JavaScript -->
    @push('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, initializing Stripe...');
            
            // Check if we have client secret
            const clientSecret = '{{ $clientSecret }}';
            if (!clientSecret) {
                console.error('No client secret found');
                document.getElementById('card-errors').textContent = 'Payment setup error. Please refresh the page.';
                return;
            }

            // Initialize Stripe
            const stripe = Stripe('{{ config("services.stripe.key") }}');
            console.log('Stripe initialized');

            const elements = stripe.elements({
                appearance: {
                    theme: 'night'
                }
            });

            // Create card element with better styling
            const cardElement = elements.create('card', {
                style: {
                    base: {
                        fontSize: '16px',
                        color: '#ffffff',
                        backgroundColor: '#374151',
                        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                        fontSmoothing: 'antialiased',
                        '::placeholder': {
                            color: '#9CA3AF'
                        },
                        iconColor: '#ffffff'
                    },
                    invalid: {
                        color: '#fa755a',
                        iconColor: '#fa755a'
                    },
                    complete: {
                        color: '#10B981'
                    }
                },
                hidePostalCode: true
            });

            // Mount the card element
            cardElement.mount('#card-element');
            console.log('Card element mounted');

            // Handle real-time validation errors from the card Element
            cardElement.on('change', function(event) {
                const displayError = document.getElementById('card-errors');
                const submitButton = document.getElementById('submit-payment');
                
                if (event.error) {
                    displayError.textContent = event.error.message;
                    submitButton.disabled = true;
                    submitButton.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    displayError.textContent = '';
                    if (event.complete) {
                        submitButton.disabled = false;
                        submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
                    }
                }
            });

            // Handle form submission
            const form = document.getElementById('checkout-form');
            form.addEventListener('submit', async function(event) {
                event.preventDefault();
                console.log('Form submitted');

                const submitButton = document.getElementById('submit-payment');
                const buttonText = document.getElementById('button-text');
                
                // Disable button and show loading
                submitButton.disabled = true;
                submitButton.classList.add('opacity-50', 'cursor-not-allowed');
                buttonText.textContent = 'Processing Payment...';

                try {
                    // Confirm payment with Stripe
                    console.log('Confirming payment with Stripe...');
                    const {error, paymentIntent} = await stripe.confirmCardPayment(clientSecret, {
                        payment_method: {
                            card: cardElement,
                            billing_details: {
                                name: document.getElementById('full_name').value,
                                email: document.getElementById('email').value,
                                phone: document.getElementById('phone').value,
                                address: {
                                    line1: document.getElementById('street_address').value,
                                    city: document.getElementById('city').value,
                                    postal_code: document.getElementById('postal_code').value,
                                }
                            }
                        }
                    });

                    if (error) {
                        console.error('Payment error:', error);
                        // Show error to customer
                        const errorElement = document.getElementById('card-errors');
                        errorElement.textContent = error.message;
                        
                        // Re-enable button
                        submitButton.disabled = false;
                        submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
                        buttonText.textContent = 'Complete Order - USD ${{ number_format($cartSummary["total"] ?? 0, 2) }}';
                    } else {
                        console.log('Payment succeeded:', paymentIntent);
                        // Payment succeeded, process the order
                        if (paymentIntent.status === 'succeeded') {
                            buttonText.textContent = 'Creating Order...';
                            // Trigger Livewire method to process order and pass PaymentIntent ID
                            @this.call('processPayment', paymentIntent.id);
                        }
                    }
                } catch (err) {
                    console.error('Unexpected error:', err);
                    document.getElementById('card-errors').textContent = 'An unexpected error occurred. Please try again.';
                    
                    // Re-enable button
                    submitButton.disabled = false;
                    submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
                    buttonText.textContent = 'Complete Order - USD ${{ number_format($cartSummary["total"] ?? 0, 2) }}';
                }
            });
        });
    </script>
    @endpush
</div>