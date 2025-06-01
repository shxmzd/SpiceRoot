<div class="min-h-screen bg-gray-900">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Order Confirmation') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Success Message -->
            <div class="text-center mb-12">
                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100 mb-6">
                    <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-green-400 mb-4">Payment Successful!</h1>
                <p class="text-xl text-gray-300">Thank you for your order. Your spices are on their way!</p>
            </div>

            <!-- Order Details -->
            <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden mb-8">
                <div class="p-6 border-b border-gray-700">
                    <h3 class="text-2xl font-bold text-orange-500">Order Details</h3>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h4 class="text-lg font-semibold text-white mb-3">Order Information</h4>
                            <div class="space-y-2">
                                <p class="text-gray-300"><span class="font-medium">Order Number:</span> {{ $order->order_number }}</p>
                                <p class="text-gray-300"><span class="font-medium">Order Date:</span> {{ $order->created_at->format('M d, Y \a\t g:i A') }}</p>
                                <p class="text-gray-300"><span class="font-medium">Payment Status:</span> 
                                    <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full ml-1">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </p>
                                <p class="text-gray-300"><span class="font-medium">Total Amount:</span> 
                                    <span class="text-green-400 font-bold">{{ $order->formatted_total }}</span>
                                </p>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-lg font-semibold text-white mb-3">Delivery Information</h4>
                            <div class="space-y-2">
                                <p class="text-gray-300"><span class="font-medium">Name:</span> {{ $order->delivery_info['full_name'] }}</p>
                                <p class="text-gray-300"><span class="font-medium">Phone:</span> {{ $order->delivery_info['phone'] }}</p>
                                <p class="text-gray-300"><span class="font-medium">Email:</span> {{ $order->delivery_info['email'] }}</p>
                                <div class="text-gray-300">
                                    <span class="font-medium">Address:</span>
                                    <div class="ml-0 mt-1">
                                        {{ $order->delivery_info['street_address'] }}<br>
                                        {{ $order->delivery_info['city'] }}, {{ $order->delivery_info['postal_code'] }}
                                    </div>
                                </div>
                                @if($order->delivery_info['delivery_notes'])
                                    <p class="text-gray-300"><span class="font-medium">Notes:</span> {{ $order->delivery_info['delivery_notes'] }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="border-t border-gray-700 pt-6">
                        <h4 class="text-lg font-semibold text-white mb-4">Order Items</h4>
                        <div class="space-y-4">
                            @foreach($order->items as $item)
                                <div class="flex items-center justify-between bg-gray-700 rounded-lg p-4">
                                    <div class="flex-1">
                                        <h5 class="text-white font-medium">{{ $item['product_name'] }}</h5>
                                        <p class="text-gray-400 text-sm">Sold by: {{ $item['seller_name'] }}</p>
                                        <p class="text-gray-400 text-sm">Quantity: {{ $item['quantity'] }}</p>
                                    </div>

                                    <div class="text-green-400 font-semibold">
                                        LKR {{ number_format($item['subtotal'], 2) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Order Summary -->
                        <div class="mt-6 bg-gray-700 rounded-lg p-4">
                            <div class="space-y-2">
                                <div class="flex justify-between text-gray-300">
                                    <span>Subtotal:</span>
                                    <span>LKR {{ number_format($order->subtotal, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-gray-300">
                                    <span>Shipping:</span>
                                    <span>LKR {{ number_format($order->shipping, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-lg font-bold text-white border-t border-gray-600 pt-2">
                                    <span>Total:</span>
                                    <span class="text-green-400">LKR {{ number_format($order->total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- What's Next -->
            <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden mb-8">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-orange-500 mb-4">What's Next?</h3>
                    <div class="space-y-3 text-gray-300">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <p>We've received your order and payment confirmation.</p>
                        </div>
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-orange-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p>Your order is being prepared and will be shipped within 2-3 business days.</p>
                        </div>
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 7.89a2 2 0 002.83 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <p>You'll receive an email confirmation and tracking information once your order ships.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="text-center space-y-4 sm:space-y-0 sm:space-x-4 sm:flex sm:justify-center">
                <button 
                    wire:click="continueShopping"
                    class="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg transition duration-200">
                    Continue Shopping
                </button>
                <button 
                    wire:click="viewDashboard"
                    class="w-full sm:w-auto bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-8 rounded-lg transition duration-200">
                    Go to Dashboard
                </button>
            </div>
        </div>
    </div>
</div>