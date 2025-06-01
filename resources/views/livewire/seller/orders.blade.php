<div class="bg-black min-h-screen text-white">
    
        <div class="bg-gradient-to-r from-gray-900 to-black border-b border-gray-800">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-orange-500 to-emerald-500 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-3xl font-bold bg-gradient-to-r from-orange-500 to-emerald-500 bg-clip-text text-transparent flex items-center">
                                My Orders
                                @if($newOrdersCount > 0)
                                    <span class="ml-3 bg-red-500 text-white text-xs rounded-full h-6 w-6 flex items-center justify-center animate-pulse">
                                        {{ $newOrdersCount }}
                                    </span>
                                @endif
                            </h2>
                            <p class="text-gray-400 text-sm">Manage your order fulfillment</p>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                        <a href="{{ route('seller.products.add') }}" 
                           class="inline-flex items-center px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg transition-all hover:scale-105 shadow-lg">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Product
                        </a>
                        <a href="{{ route('seller.dashboard') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white font-semibold rounded-lg transition-all hover:scale-105 shadow-lg">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            </svg>
                            Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Success/Error Messages -->
            @if (session()->has('success'))
                <div class="mb-6 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-6 py-4 rounded-xl relative backdrop-blur-sm" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    </div>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-6 bg-red-500/10 border border-red-500/20 text-red-400 px-6 py-4 rounded-xl relative backdrop-blur-sm" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L10 10.586l1.293-1.293a1 1 0 001.414-1.414L10 8.586l-1.293-1.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <span class="font-medium">{{ session('error') }}</span>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Filters Section -->
            <div class="bg-gray-900/50 backdrop-blur-xl border border-gray-800 rounded-2xl shadow-2xl overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-orange-500/10 to-emerald-500/10 p-6 border-b border-gray-800">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Filter Orders
                    </h3>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Status Filter -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-300">Status</label>
                            <select wire:model.live="statusFilter" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all">
                                @foreach($statusOptions as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Search -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-300">Search</label>
                            <input 
                                type="text" 
                                wire:model.live.debounce.300ms="searchTerm"
                                placeholder="Order # or Customer name"
                                class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all"
                            >
                        </div>

                        <!-- Date From -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-300">From Date</label>
                            <input 
                                type="date" 
                                wire:model.live="dateFrom"
                                class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all"
                            >
                        </div>

                        <!-- Date To -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-300">To Date</label>
                            <input 
                                type="date" 
                                wire:model.live="dateTo"
                                class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all"
                            >
                        </div>
                    </div>

                    <!-- Clear Filters -->
                    <div class="mt-6 flex justify-end">
                        <button 
                            wire:click="clearFilters"
                            class="bg-gray-700 hover:bg-gray-600 text-white font-semibold py-2 px-6 rounded-lg transition-all hover:scale-105"
                        >
                            Clear Filters
                        </button>
                    </div>
                </div>
            </div>

            <!-- Orders List -->
            @if($orders->count() > 0)
                <div class="space-y-6">
                    @foreach($orders as $order)
                        <div class="bg-gray-900/50 backdrop-blur-xl border border-gray-800 rounded-2xl shadow-2xl overflow-hidden hover:border-gray-700 transition-all">
                            <!-- Order Header -->
                            <div class="bg-gradient-to-r from-gray-800/50 to-gray-900/50 p-6 border-b border-gray-800">
                                <div class="flex flex-wrap items-center justify-between gap-4">
                                    <div class="flex items-center space-x-4">
                                        <h3 class="text-xl font-bold text-white">
                                            Order #{{ $order->order_number }}
                                        </h3>
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-yellow-500/20 text-yellow-400 border border-yellow-500/50',
                                                'confirmed' => 'bg-blue-500/20 text-blue-400 border border-blue-500/50',
                                                'shipped' => 'bg-purple-500/20 text-purple-400 border border-purple-500/50',
                                                'delivered' => 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/50',
                                                'cancelled' => 'bg-red-500/20 text-red-400 border border-red-500/50'
                                            ];
                                            $statusClass = $statusColors[$order->status] ?? 'bg-gray-500/20 text-gray-400 border border-gray-500/50';
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                                            @if($order->status === 'pending')
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @elseif($order->status === 'confirmed')
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @elseif($order->status === 'shipped')
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                                </svg>
                                            @elseif($order->status === 'delivered')
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            @elseif($order->status === 'cancelled')
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            @endif
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                    
                                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-400">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 9l6 6-6 6"></path>
                                            </svg>
                                            {{ $order->created_at->format('M d, Y') }}
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            {{ $order->delivery_info['full_name'] }}
                                        </div>
                                        <div class="flex items-center font-semibold bg-gradient-to-r from-emerald-400 to-green-400 bg-clip-text text-transparent">
                                            <svg class="w-4 h-4 mr-1 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                            </svg>
                                            USD ${{ number_format($order->getSellerTotal(auth()->id()), 2) }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Items (Seller's items only) -->
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                                    @foreach($order->getSellerItems(auth()->id()) as $item)
                                        <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700 rounded-xl p-4 hover:bg-gray-800/70 transition-all">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-10 h-10 bg-gradient-to-br from-orange-500/20 to-emerald-500/20 rounded-lg flex items-center justify-center border border-gray-600">
                                                    <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                    </svg>
                                                </div>
                                                <div class="flex-1">
                                                    <h4 class="font-semibold text-white text-sm">{{ $item['product_name'] }}</h4>
                                                    <div class="flex items-center justify-between mt-1">
                                                        <span class="text-xs text-gray-400">Qty: {{ $item['quantity'] }}</span>
                                                        <span class="text-sm font-semibold bg-gradient-to-r from-emerald-400 to-green-400 bg-clip-text text-transparent">
                                                            USD ${{ number_format($item['subtotal'], 2) }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex flex-wrap gap-3">
                                    @if($order->canBeCancelledBySeller(auth()->id()))
                                        <button 
                                            wire:click="cancelOrder('{{ $order->_id }}')"
                                            onclick="return confirm('Are you sure you want to cancel this order?')"
                                            class="bg-red-600/20 hover:bg-red-600/30 border border-red-600/50 hover:border-red-600 text-red-400 hover:text-red-300 font-semibold py-2 px-4 rounded-lg transition-all hover:scale-105"
                                        >
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            Cancel Order
                                        </button>
                                    @endif

                                    @if($order->canBeShippedBySeller(auth()->id()))
                                        <button 
                                            wire:click="shipOrder('{{ $order->_id }}')"
                                            class="bg-purple-600/20 hover:bg-purple-600/30 border border-purple-600/50 hover:border-purple-600 text-purple-400 hover:text-purple-300 font-semibold py-2 px-4 rounded-lg transition-all hover:scale-105"
                                        >
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                            </svg>
                                            Mark as Shipped
                                        </button>
                                    @endif

                                    @if($order->canBeDeliveredBySeller(auth()->id()))
                                        <button 
                                            wire:click="deliverOrder('{{ $order->_id }}')"
                                            class="bg-emerald-600/20 hover:bg-emerald-600/30 border border-emerald-600/50 hover:border-emerald-600 text-emerald-400 hover:text-emerald-300 font-semibold py-2 px-4 rounded-lg transition-all hover:scale-105"
                                        >
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Mark as Delivered
                                        </button>
                                    @endif

                                    <a 
                                        href="{{ route('seller.order.details', $order->_id) }}"
                                        class="bg-blue-600/20 hover:bg-blue-600/30 border border-blue-600/50 hover:border-blue-600 text-blue-400 hover:text-blue-300 font-semibold py-2 px-4 rounded-lg transition-all hover:scale-105"
                                    >
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8 flex justify-center">
                    {{ $orders->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-gray-900/50 backdrop-blur-xl border border-gray-800 rounded-2xl shadow-2xl p-12 text-center">
                    <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-gray-700/50 to-gray-800/50 rounded-full flex items-center justify-center border border-gray-700">
                        <svg class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">No orders found</h3>
                    <p class="text-gray-400 mb-6 max-w-md mx-auto">
                        @if($statusFilter || $searchTerm || $dateFrom || $dateTo)
                            Try adjusting your filters to see more results.
                        @else
                            You haven't received any orders yet. Keep adding great products to attract customers!
                        @endif
                    </p>
                    @if($statusFilter || $searchTerm || $dateFrom || $dateTo)
                        <button 
                            wire:click="clearFilters"
                            class="inline-flex items-center px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg transition-all hover:scale-105 shadow-lg"
                        >
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Clear Filters
                        </button>
                    @else
                        <a href="{{ route('seller.products.add') }}" 
                           class="inline-flex items-center px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg transition-all hover:scale-105 shadow-lg">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Your First Product
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>