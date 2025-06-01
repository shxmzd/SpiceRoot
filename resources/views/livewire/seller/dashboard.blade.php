

    <div class="min-h-screen" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);">
    <style>
        .glow {
            text-shadow: 0 0 10px rgba(255, 107, 53, 0.5), 
                         0 0 20px rgba(255, 107, 53, 0.3), 
                         0 0 30px rgba(255, 107, 53, 0.2);
        }
        
        /* Custom scrollbar for tables */
        .overflow-x-auto::-webkit-scrollbar {
            height: 6px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-track {
            background: rgba(31, 41, 55, 0.5);
            border-radius: 3px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: rgba(249, 115, 22, 0.6);
            border-radius: 3px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: rgba(249, 115, 22, 0.8);
        }
    </style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl md:text-5xl font-bold text-orange-500 mb-4 glow">Seller Dashboard</h1>
                <p class="text-gray-300 text-lg">Manage your products and track your sales</p>
            </div>

            <!-- Seller Notifications -->
            <div class="flex justify-end mb-4">
                <div class="relative">
                    <button id="notificationDropdownButton" type="button" class="relative inline-flex items-center px-4 py-2 bg-gray-800/50 backdrop-blur-sm border border-gray-700 rounded-lg shadow-lg text-sm font-medium text-gray-200 hover:bg-gray-700/50 hover:border-orange-500/50 focus:outline-none transition-all duration-200" onclick="document.getElementById('notificationDropdown').classList.toggle('hidden')">
                        <svg class="w-6 h-6 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 7.165 6 9.388 6 12v2.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span>Notifications</span>
                        @if($notificationCount > 0)
                            <span class="ml-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-gradient-to-r from-red-500 to-red-600 rounded-full animate-pulse">{{ $notificationCount }}</span>
                        @endif
                    </button>
                    <div id="notificationDropdown" class="hidden absolute right-0 mt-2 w-80 bg-gray-800/95 backdrop-blur-sm border border-gray-700 rounded-lg shadow-xl z-50">
                        <div class="p-4 border-b border-gray-700 font-semibold text-orange-500">Recent Notifications</div>
                        <ul class="max-h-64 overflow-y-auto">
                            @forelse($recentNotifications as $notification)
                                <li class="px-4 py-3 border-b border-gray-700 flex items-start {{ !$notification->is_read ? 'bg-orange-900/30' : '' }}">
                                    <div class="flex-1">
                                        <div class="text-sm text-gray-100">{!! $notification->message !!}</div>
                                        <div class="text-xs text-gray-400 mt-1">Order #: {{ $notification->order_number }} &middot; {{ $notification->created_at->diffForHumans() }}</div>
                                    </div>
                                    @if(!$notification->is_read)
                                        <button wire:click="markNotificationAsRead('{{ $notification->_id }}')" class="ml-3 text-xs text-orange-400 hover:text-orange-300 hover:underline">Mark as read</button>
                                    @endif
                                </li>
                            @empty
                                <li class="px-4 py-3 text-gray-400">No notifications</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Add New Product & View Products Navigation Buttons -->
            <div class="flex justify-end mb-4 gap-4">
                <a href="{{ route('seller.products.add') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white font-bold rounded-lg transform hover:scale-105 transition duration-200 shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add New Product
                </a>
                <a href="{{ route('seller.products.view') }}" 
                   class="inline-flex items-center px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-lg transform hover:scale-105 transition duration-200 shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    View Products
                </a>
            </div>
            
            <!-- Success/Error Messages -->
            @if (session()->has('success'))
                <div class="bg-green-900/80 backdrop-blur-sm border border-green-500 text-green-300 px-4 py-3 rounded-lg shadow-lg" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="bg-red-900/80 backdrop-blur-sm border border-red-500 text-red-300 px-4 py-3 rounded-lg shadow-lg" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Section 1: Add New Product -->
            <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700 overflow-hidden shadow-xl rounded-lg">
                <div class="p-6 lg:p-8">
                    <h3 class="text-2xl font-semibold text-orange-400 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Add New Product
                    </h3>
                    
                    <form wire:submit.prevent="addProduct" enctype="multipart/form-data" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <!-- Product Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Product Name</label>
                                <input 
                                    type="text" 
                                    id="name"
                                    wire:model="name" 
                                    placeholder="e.g., Saffron Threads"
                                    class="w-full px-4 py-3 rounded-lg bg-gray-700/50 border border-gray-600 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all duration-200"
                                >
                                @error('name') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Category -->
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-300 mb-2">Category</label>
                                <select 
                                    id="category"
                                    wire:model="category"
                                    class="w-full px-4 py-3 rounded-lg bg-gray-700/50 border border-gray-600 text-white focus:outline-none focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all duration-200"
                                >
                                    <option value="" class="text-gray-400">Select Category</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat }}" class="text-white">{{ $cat }}</option>
                                    @endforeach
                                </select>
                                @error('category') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Price -->
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-300 mb-2">Price (Rs)</label>
                                <input 
                                    type="number" 
                                    id="price"
                                    wire:model="price" 
                                    step="0.01"
                                    placeholder="e.g., 29.99"
                                    class="w-full px-4 py-3 rounded-lg bg-gray-700/50 border border-gray-600 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all duration-200"
                                >
                                @error('price') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Product Image -->
                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-300 mb-2">Product Image</label>
                                <div class="relative">
                                    <input 
                                        type="file" 
                                        id="image"
                                        wire:model="image" 
                                        accept="image/*"
                                        class="w-full px-4 py-3 rounded-lg bg-gray-700/50 border border-gray-600 text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-500 file:text-white hover:file:bg-orange-600 file:cursor-pointer focus:outline-none focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all duration-200"
                                    >
                                </div>
                                @error('image') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
                                
                                <!-- Image Preview -->
                                @if ($image)
                                    <div class="mt-3">
                                        <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="h-20 w-20 object-cover rounded-lg border-2 border-orange-500 shadow-lg">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                            <textarea 
                                id="description"
                                wire:model="description" 
                                rows="4"
                                placeholder="e.g., Hand-picked saffron, bursting with vibrant flavor and aroma."
                                class="w-full px-4 py-3 rounded-lg bg-gray-700/50 border border-gray-600 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all duration-200 resize-none"
                            ></textarea>
                            @error('description') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button 
                                type="submit" 
                                class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white font-bold rounded-lg transform hover:scale-105 transition-all duration-200 shadow-lg focus:outline-none focus:ring-2 focus:ring-orange-500/50 disabled:opacity-50 disabled:cursor-not-allowed"
                                wire:loading.attr="disabled"
                            >
                                <span wire:loading.remove class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Add Product
                                </span>
                                <span wire:loading class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Adding...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Section 2: Your Products -->
            <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700 overflow-hidden shadow-xl rounded-lg">
                <div class="p-6 lg:p-8">
                    <h3 class="text-2xl font-semibold text-orange-400 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        Your Products
                    </h3>
                    
                    @if($products->count() > 0)
                        <div class="overflow-x-auto rounded-lg">
                            <table class="min-w-full divide-y divide-gray-600">
                                <thead class="bg-gray-700/50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-orange-400 uppercase tracking-wider">Product Name</th>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-orange-400 uppercase tracking-wider">Category</th>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-orange-400 uppercase tracking-wider">Price</th>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-orange-400 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-gray-800/30 divide-y divide-gray-600">
                                    @foreach($products as $product)
                                        <tr class="hover:bg-gray-700/30 transition-colors duration-200">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    @if($product->image)
                                                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="h-12 w-12 rounded-lg object-cover mr-4 border border-gray-600">
                                                    @else
                                                        <div class="h-12 w-12 rounded-lg bg-gray-600 mr-4 flex items-center justify-center">
                                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                    <div class="text-sm font-medium text-white">{{ $product->name }}</div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $product->category }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 font-semibold">{{ $product->formatted_price }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-3">
                                                <a 
                                                    href="{{ route('seller.products.view', ['edit' => $product->_id]) }}"
                                                    class="inline-flex items-center px-3 py-1.5 bg-orange-500/20 text-orange-400 hover:bg-orange-500/30 hover:text-orange-300 rounded-lg transition-all duration-200 border border-orange-500/30"
                                                >
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                    Edit
                                                </a>
                                                <button 
                                                    x-data
                                                    @click.prevent="if (confirm('Are you sure you want to delete this product?')) { $wire.deleteProduct('{{ $product->_id }}') }"
                                                    class="inline-flex items-center px-3 py-1.5 bg-red-500/20 text-red-400 hover:bg-red-500/30 hover:text-red-300 rounded-lg transition-all duration-200 border border-red-500/30"
                                                >
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="bg-gray-700/30 rounded-full w-24 h-24 mx-auto mb-4 flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-300 mb-2">No products yet</h3>
                            <p class="text-gray-400 mb-6">Get started by adding your first product to your store.</p>
                            <a href="#" onclick="document.querySelector('form').scrollIntoView({ behavior: 'smooth' })" class="inline-flex items-center px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Add First Product
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


