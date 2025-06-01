@php
    use App\Models\Review;
@endphp
<div class="min-h-screen relative" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);">
    <x-slot name="header">
        <div class="relative shadow-2xl border-b border-orange-500/30" style="background: linear-gradient(145deg, #2a2a2a, #1f1f1f);">
            <div class="flex items-center justify-between p-6">
                <div class="flex items-center space-x-4">
                    <div class="h-12 w-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center shadow-xl">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h2 class="font-bold text-3xl bg-gradient-to-r from-orange-400 to-orange-600 bg-clip-text text-transparent">
                        {{ __('My Orders') }}
                    </h2>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('buyer.shop') }}" class="button-3d bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-3 px-6 rounded-full transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                        Continue Shopping
                    </a>
                    <a href="{{ route('buyer.dashboard') }}" class="button-3d bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white font-bold py-3 px-6 rounded-full transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                        Dashboard
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="relative z-10 py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Success/Error Messages -->
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

            @if (session()->has('error'))
                <div class="mb-8 bg-gradient-to-r from-red-500 to-red-600 text-white px-6 py-4 rounded-xl shadow-2xl border border-red-400/50 transform hover:scale-105 transition-all duration-300" role="alert">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="font-semibold">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Hero Section -->
            <div class="text-center mb-12">
                <h1 class="text-5xl md:text-6xl font-bold bg-gradient-to-r from-orange-400 via-orange-500 to-orange-600 bg-clip-text text-transparent mb-4">
                    My Orders
                </h1>
                <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                    Track your spice journey and order history
                </p>
            </div>

            <!-- Search and Filter Section -->
            <div class="rounded-2xl shadow-2xl p-8 mb-12 border border-gray-600/30" style="background: linear-gradient(145deg, #2a2a2a, #1f1f1f);">
                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Search -->
                    <div class="flex-1">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-orange-500/20 to-green-500/20 rounded-xl blur-lg"></div>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    wire:model.live.debounce.300ms="searchTerm"
                                    placeholder="Search orders by ID, product name, or date..."
                                    class="w-full px-6 py-4 text-white rounded-xl border border-gray-600/50 focus:border-orange-500 focus:ring-4 focus:ring-orange-500/25 transition-all duration-300 text-lg placeholder-gray-400 shadow-xl"
                                    style="background: linear-gradient(145deg, #1f1f1f, #2a2a2a);"
                                >
                            </div>
                        </div>
                    </div>
                    
                    <!-- Status Filter -->
                    <div>
                        <div class="relative">
                            <select 
                                wire:model.live="statusFilter"
                                class="px-6 py-4 text-white rounded-xl border border-gray-600/50 focus:border-orange-500 focus:ring-4 focus:ring-orange-500/25 transition-all duration-300 appearance-none cursor-pointer shadow-xl"
                                style="background: linear-gradient(145deg, #1f1f1f, #2a2a2a);"
                            >
                                @foreach($statusOptions as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <div class="absolute right-4 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12">
                <!-- Total Orders -->
                <div class="card-3d rounded-xl p-6 text-center transform hover:scale-105 transition-all duration-300">
                    <div class="text-4xl font-bold text-orange-500 glow mb-3">{{ $stats['total_orders'] }}</div>
                    <div class="text-gray-300 text-lg">Total Orders</div>
                </div>

                <!-- Processing -->
                <div class="card-3d rounded-xl p-6 text-center transform hover:scale-105 transition-all duration-300">
                    <div class="text-4xl font-bold text-yellow-500 glow mb-3">{{ $stats['processing_orders'] }}</div>
                    <div class="text-gray-300 text-lg">Processing</div>
                </div>

                <!-- Delivered -->
                <div class="card-3d rounded-xl p-6 text-center transform hover:scale-105 transition-all duration-300">
                    <div class="text-4xl font-bold text-green-500 glow mb-3">{{ $stats['delivered_orders'] }}</div>
                    <div class="text-gray-300 text-lg">Delivered</div>
                </div>

                <!-- Total Spent -->
                <div class="card-3d rounded-xl p-6 text-center transform hover:scale-105 transition-all duration-300">
                    <div class="text-4xl font-bold text-blue-500 glow mb-3">Rs. {{ number_format($stats['total_spent'], 2) }}</div>
                    <div class="text-gray-300 text-lg">Total Spent</div>
                </div>
            </div>

            <!-- Orders List -->
            @if($orders->count() > 0)
                <div class="space-y-8">
                    @foreach($orders as $order)
                        <div class="card-3d rounded-2xl overflow-hidden shadow-2xl border border-gray-600/30 transform hover:scale-[1.02] transition-all duration-300">
                            <!-- Order Header -->
                            <div class="p-8 border-b border-gray-600/30" style="background: linear-gradient(145deg, #2a2a2a, #1f1f1f);">
                                <div class="flex flex-wrap items-center justify-between gap-6">
                                    <div class="flex items-center space-x-4">
                                        <div class="h-16 w-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-xl transform rotate-3">
                                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-2xl font-bold text-orange-500 glow mb-2">Order #{{ $order->order_number }}</h3>
                                            <p class="text-gray-300 text-lg">
                                                <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M8 7V3a1 1 0 012 0v4h4V3a1 1 0 012 0v4h2a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V9a2 2 0 012-2h2z"/>
                                                </svg>
                                                {{ $order->created_at->format('M d, Y \a\t h:i A') }}
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center space-x-6">
                                        <div class="text-center">
                                            <div class="text-3xl font-bold text-green-400 glow mb-1">USD ${{ number_format($order->total, 2) }}</div>
                                            <div class="text-gray-400 text-sm">Total Amount</div>
                                        </div>
                                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold shadow-lg border border-opacity-50 {{ $order->status_badge['class'] }}">
                                            <div class="w-2 h-2 rounded-full mr-2 {{ str_contains($order->status_badge['class'], 'green') ? 'bg-green-400' : (str_contains($order->status_badge['class'], 'yellow') ? 'bg-yellow-400' : 'bg-gray-400') }}"></div>
                                            {{ $order->status_badge['text'] }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 p-8">
                                <!-- Items Ordered -->
                                <div class="xl:col-span-2">
                                    <div class="flex items-center mb-6">
                                        <div class="h-10 w-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h3a1 1 0 110 2h-1v11a3 3 0 01-3 3H8a3 3 0 01-3-3V6H4a1 1 0 110-2h3zM9 3v1h6V3H9zm0 5a1 1 0 012 0v6a1 1 0 11-2 0V8zm4 0a1 1 0 012 0v6a1 1 0 11-2 0V8z"/>
                                            </svg>
                                        </div>
                                        <h4 class="text-xl font-bold text-white">Items Ordered</h4>
                                    </div>
                                    <div class="space-y-3">
                                        @foreach($order->items as $item)
                                            <div class="flex items-center space-x-4 p-4 rounded-lg bg-gray-800/50 border border-gray-700/50">
                                                <!-- Product Image -->
                                                <div class="w-14 h-14 rounded-lg overflow-hidden flex-shrink-0">
                                                    @if(isset($item['product_image']) && $item['product_image'])
                                                        <img 
                                                            src="{{ Storage::url($item['product_image']) }}" 
                                                            alt="{{ $item['product_name'] }}"
                                                            class="w-full h-full object-cover"
                                                            loading="lazy"
                                                        >
                                                    @else
                                                        <div class="w-full h-full bg-gray-600 flex items-center justify-center">
                                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                
                                                <div class="flex-1">
                                                    <h5 class="font-medium text-white mb-1">{{ $item['product_name'] }}</h5>
                                                    <div class="text-sm text-gray-400">
                                                        Quantity: {{ $item['quantity'] }} × ${{ number_format($item['price'], 2) }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Order Status Timeline -->
                                <div>
                                    <div class="flex items-center mb-6">
                                        <div class="h-10 w-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                            </svg>
                                        </div>
                                        <h4 class="text-xl font-bold text-white">Order Progress</h4>
                                    </div>
                                    <div class="space-y-4">
                                        @foreach(($order->timeline ?? []) as $step)
                                            <div class="flex items-start space-x-4 p-4 rounded-xl {{ $step['completed'] ? 'bg-green-500/10 border border-green-500/30' : 'bg-gray-700/50 border border-gray-600/30' }} transition-all duration-300">
                                                <div class="w-8 h-8 rounded-full mt-1 flex items-center justify-center shadow-lg {{ $step['completed'] ? 'bg-gradient-to-br from-green-500 to-green-600' : 'bg-gradient-to-br from-gray-500 to-gray-600' }}">
                                                    @if($step['completed'])
                                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                                        </svg>
                                                    @else
                                                        <div class="w-3 h-3 bg-white rounded-full"></div>
                                                    @endif
                                                </div>
                                                <div class="flex-1">
                                                    <p class="font-bold text-lg {{ $step['completed'] ? 'text-green-400 glow' : 'text-gray-400' }}">
                                                        {{ $step['status'] }}
                                                    </p>
                                                    <p class="text-sm text-gray-400 mt-1">{{ $step['date'] }}</p>
                                                    @if(isset($step['description']))
                                                        <p class="text-sm text-gray-300 mt-2 bg-gray-800/50 p-2 rounded-lg">{{ $step['description'] }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="p-8 border-t border-gray-600/30" style="background: linear-gradient(145deg, #1f1f1f, #2a2a2a);">
                                <div class="flex flex-wrap gap-4">
                                    @if($order->canBeCancelledByBuyer())
                                        <button 
                                            wire:click="cancelOrder('{{ $order->_id }}')"
                                            onclick="return confirm('Are you sure you want to cancel this order?')"
                                            class="button-3d bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-2xl"
                                        >
                                            <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                            Cancel Order
                                        </button>
                                    @endif

                                    @if($order->canBeReordered())
                                        <button 
                                            wire:click="reorder('{{ $order->_id }}')"
                                            class="button-3d bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-2xl"
                                        >
                                            <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                            </svg>
                                            Reorder Items
                                        </button>
                                    @endif

                                    @if($order->canBeRated())
                                        @foreach($order->items as $item)
                                            @if(!Review::hasUserReviewed(auth()->id(), $item['product_id'], $order->_id))
                                                <button 
                                                    wire:click="openReviewModal('{{ $item['product_id'] }}', '{{ $order->_id }}')"
                                                    class="button-3d bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-2xl"
                                                >
                                                    <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                                    </svg>
                                                    Rate {{ $item['product_name'] }}
                                                </button>
                                            @else
                                                <span class="inline-flex items-center px-6 py-3 rounded-xl font-bold text-white bg-gray-600/50 border border-gray-500/50">
                                                    <svg class="w-5 h-5 mr-2 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                                    </svg>
                                                    {{ $item['product_name'] }} Reviewed
                                                </span>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12 flex justify-center">
                    <div class="card-3d rounded-2xl p-6 shadow-2xl">
                        {{ $orders->links() }}
                    </div>
                </div>

                <!-- Load More Button (Visual) -->
                <div class="text-center mt-8">
                    <button class="button-3d bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold py-4 px-8 rounded-2xl transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                        <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8-8-8z"/>
                        </svg>
                        Load More Orders
                    </button>
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-20">
                    <div class="card-3d rounded-3xl p-12 max-w-2xl mx-auto">
                        <div class="relative mb-8">
                            <div class="h-32 w-32 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full flex items-center justify-center mx-auto shadow-2xl">
                                <svg class="h-16 w-16 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="absolute -top-4 -right-4 h-8 w-8 bg-gradient-to-br from-green-400 to-green-600 rounded-full animate-pulse"></div>
                            <div class="absolute -bottom-4 -left-4 h-6 w-6 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full animate-pulse"></div>
                        </div>
                        
                        <h3 class="text-4xl font-bold bg-gradient-to-r from-orange-400 to-orange-600 bg-clip-text text-transparent mb-6">
                            No Orders Found
                        </h3>
                        
                        <p class="text-gray-300 mb-8 text-xl leading-relaxed">
                            @if($statusFilter || $searchTerm)
                                Try adjusting your search or filter criteria to find the orders you're looking for.
                            @else
                                You haven't placed any orders yet. Start exploring our amazing collection of spices and create your first order!
                            @endif
                        </p>
                        
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('buyer.shop') }}" class="button-3d bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-4 px-8 rounded-2xl transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                                <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h3a1 1 0 110 2h-1v11a3 3 0 01-3 3H8a3 3 0 01-3-3V6H4a1 1 0 110-2h3z"/>
                                </svg>
                                Start Shopping
                            </a>
                            
                            @if($statusFilter || $searchTerm)
                                <button wire:click="clearFilters" class="button-3d bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white font-bold py-4 px-8 rounded-2xl transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                                    <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Clear Filters
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Review Modal -->
    @if($showReviewModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-black/70 backdrop-blur-sm transition-opacity" wire:click="closeReviewModal"></div>

                <!-- Modal panel -->
                <div class="inline-block align-bottom overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="card-3d rounded-2xl border border-gray-600/30">
                        <form wire:submit.prevent="submitReview">
                            <div class="p-8" style="background: linear-gradient(145deg, #2a2a2a, #1f1f1f);">
                                <div class="flex items-center justify-between mb-8">
                                    <div class="flex items-center space-x-4">
                                        <div class="h-12 w-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-xl">
                                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                            </svg>
                                        </div>
                                        <h3 class="text-2xl font-bold bg-gradient-to-r from-green-400 to-green-600 bg-clip-text text-transparent">
                                            Rate & Review Product
                                        </h3>
                                    </div>
                                    <button type="button" wire:click="closeReviewModal" class="text-gray-400 hover:text-white transition-colors p-2 rounded-lg hover:bg-gray-700/50">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>

                                <div class="space-y-6">
                                    <!-- Rating -->
                                    <div>
                                        <label class="block text-lg font-bold text-white mb-4">Rating *</label>
                                        <div class="flex space-x-2 justify-center p-4 rounded-xl" style="background: linear-gradient(145deg, #1f1f1f, #2a2a2a);">
                                            @for($i = 1; $i <= 5; $i++)
                                                <button 
                                                    type="button"
                                                    wire:click="$set('rating', {{ $i }})"
                                                    class="text-4xl {{ $rating >= $i ? 'text-yellow-400 glow' : 'text-gray-600' }} hover:text-yellow-400 transition-all duration-300 transform hover:scale-110"
                                                >
                                                    ★
                                                </button>
                                            @endfor
                                        </div>
                                        @error('rating') <span class="text-red-400 text-sm mt-2 block">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Review Text -->
                                    <div>
                                        <label class="block text-lg font-bold text-white mb-4">Review *</label>
                                        <div class="relative">
                                            <div class="absolute inset-0 bg-gradient-to-r from-green-500/20 to-blue-500/20 rounded-xl blur-lg"></div>
                                            <div class="relative">
                                                <textarea 
                                                    wire:model="reviewText"
                                                    rows="5"
                                                    class="w-full px-6 py-4 text-white rounded-xl border border-gray-600/50 focus:border-green-500 focus:ring-4 focus:ring-green-500/25 transition-all duration-300 placeholder-gray-400 resize-none shadow-xl"
                                                    style="background: linear-gradient(145deg, #1f1f1f, #2a2a2a);"
                                                    placeholder="Share your experience with this product... What did you love about it? How was the quality, taste, and packaging?"
                                                ></textarea>
                                            </div>
                                        </div>
                                        @error('reviewText') <span class="text-red-400 text-sm mt-2 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Footer -->
                            <div class="p-6 border-t border-gray-600/30 flex flex-col sm:flex-row-reverse gap-3" style="background: linear-gradient(145deg, #1f1f1f, #2a2a2a);">
                                <button 
                                    type="submit"
                                    class="button-3d bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-3 px-8 rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-2xl"
                                    wire:loading.attr="disabled"
                                >
                                    <span wire:loading.remove class="flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                        </svg>
                                        Submit Review
                                    </span>
                                    <span wire:loading class="flex items-center">
                                        <svg class="w-5 h-5 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Submitting...
                                    </span>
                                </button>
                                <button 
                                    type="button"
                                    wire:click="closeReviewModal"
                                    class="button-3d bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white font-bold py-3 px-8 rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-2xl"
                                >
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <style>
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
            color:rgba(0, 0, 0, 0.5) !important;
        }
        
        select option:selected {
            background: linear-gradient(145deg, #f97316, #ea580c) !important;
            color:rgba(0, 0, 0, 0.5) !important;
        }
        
        /* Enhanced focus styles */
        select:focus,
        input:focus {
            outline: none;
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.25);
            border-color: #f97316;
        }
        
        /* Additional 3D effects for dropdowns */
        select {
            box-shadow: 
                0 8px 16px rgba(0, 0, 0, 0.4),
                inset 0 1px 0 rgba(255, 255, 255, 0.1),
                inset 0 -1px 0 rgba(0, 0, 0, 0.2);
            transform: translateZ(0);
            transition: all 0.3s ease;
        }
        
        select:hover {
            transform: translateY(-2px);
            box-shadow: 
                0 12px 24px rgba(0, 0, 0, 0.5),
                inset 0 1px 0 rgba(255, 255, 255, 0.2),
                inset 0 -1px 0 rgba(0, 0, 0, 0.2);
        }
        
        select:active {
            transform: translateY(0px);
            box-shadow: 
                0 4px 8px rgba(0, 0, 0, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.1),
                inset 0 -1px 0 rgba(0, 0, 0, 0.1);
        }
        
        /* Enhanced button styling */
        .button-3d {
            position: relative;
            overflow: hidden;
            box-shadow: 
                0 8px 16px rgba(0, 0, 0, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }
        
        .button-3d:hover {
            transform: translateY(-2px);
            box-shadow: 
                0 12px 24px rgba(0, 0, 0, 0.4),
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