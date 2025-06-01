<div class="bg-black min-h-screen text-white">
    
        <div class="bg-gradient-to-r from-gray-900 to-black border-b border-gray-800">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-orange-500 to-emerald-500 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-3xl font-bold bg-gradient-to-r from-orange-500 to-emerald-500 bg-clip-text text-transparent">
                                Your Product Collection
                            </h2>
                            <p class="text-gray-400 text-sm">Manage your spice inventory</p>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                        <a href="{{ route('seller.products.add') }}" 
                           class="inline-flex items-center px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg transition-all hover:scale-105 shadow-lg">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add New Product
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

            <!-- Search and Filter Bar -->
            <div class="bg-gray-900/50 backdrop-blur-xl border border-gray-800 rounded-2xl shadow-2xl overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-orange-500/10 to-emerald-500/10 p-6 border-b border-gray-800">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Search & Filter Products
                    </h3>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        
                        <!-- Search Bar -->
                        <div class="md:col-span-2 space-y-2">
                            <label for="search" class="block text-sm font-semibold text-gray-300">Search Products</label>
                            <input 
                                type="text" 
                                id="search"
                                wire:model.live.debounce.300ms="search"
                                placeholder="Search by name, description, or category..."
                                class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all"
                            >
                        </div>

                        <!-- Category Filter -->
                        <div class="space-y-2">
                            <label for="category" class="block text-sm font-semibold text-gray-300">Category</label>
                            <select 
                                id="category"
                                wire:model.live="selectedCategory"
                                class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all"
                            >
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}">{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Apply Button (Visual - functionality is automatic) -->
                    <div class="mt-6 flex justify-end">
                        <div class="inline-flex items-center px-4 py-2 bg-orange-500/20 border border-orange-500/50 text-orange-400 font-semibold rounded-lg">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Filters Applied Live
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            @if($products->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                    @foreach($products as $product)
                        <div class="bg-gray-900/50 backdrop-blur-xl border border-gray-800 rounded-2xl shadow-2xl overflow-hidden transform hover:scale-105 transition-all duration-300 hover:border-gray-700 group">
                            
                            <!-- Product Image -->
                            <div class="h-48 bg-gray-700 flex items-center justify-center relative overflow-hidden">
                                @if($product->image)
                                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                @else
                                    <div class="text-center text-gray-400">
                                        <svg class="w-16 h-16 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-sm opacity-75">No Image</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Product Details -->
                            <div class="p-6">
                                <!-- Product Name -->
                                <h4 class="text-xl font-bold text-white mb-2 group-hover:text-orange-400 transition-colors">
                                    {{ $product->name }}
                                </h4>

                                <!-- Category -->
                                <div class="mb-3">
                                    <span class="inline-block bg-orange-500/20 text-orange-400 border border-orange-500/50 text-xs px-3 py-1 rounded-full font-semibold">
                                        {{ $product->category }}
                                    </span>
                                </div>

                                <!-- Price -->
                                <div class="mb-4">
                                    <span class="text-2xl font-bold bg-gradient-to-r from-orange-400 to-emerald-400 bg-clip-text text-transparent">
                                        {{ $product->formatted_price }}
                                    </span>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex space-x-2">
                                    <button 
                                        wire:click="openEditModal('{{ $product->_id }}')"
                                        class="flex-1 bg-blue-600/20 hover:bg-blue-600/30 border border-blue-600/50 hover:border-blue-600 text-blue-400 hover:text-blue-300 font-semibold py-2 px-3 rounded-lg transition-all hover:scale-105 flex items-center justify-center"
                                    >
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </button>
                                    <button 
                                        x-data
                                        @click.prevent="if (confirm('Are you sure you want to delete this product?')) { $wire.deleteProduct('{{ $product->_id }}') }"
                                        class="flex-1 bg-red-600/20 hover:bg-red-600/30 border border-red-600/50 hover:border-red-600 text-red-400 hover:text-red-300 font-semibold py-2 px-3 rounded-lg transition-all hover:scale-105 flex items-center justify-center"
                                    >
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8 flex justify-center">
                    {{ $products->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-gray-900/50 backdrop-blur-xl border border-gray-800 rounded-2xl shadow-2xl p-12 text-center">
                    <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-gray-700/50 to-gray-800/50 rounded-full flex items-center justify-center border border-gray-700">
                        <svg class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">No products found</h3>
                    <p class="text-gray-400 mb-6 max-w-md mx-auto">
                        @if($search || $selectedCategory)
                            Try adjusting your search or filter criteria to find more products.
                        @else
                            Start building your spice collection by adding your first premium product.
                        @endif
                    </p>
                    @if(!$search && !$selectedCategory)
                        <a href="{{ route('seller.products.add') }}" 
                           class="inline-flex items-center px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg transition-all hover:scale-105 shadow-lg">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Your First Product
                        </a>
                    @else
                        <button 
                            wire:click="$set('search', '')"
                            onclick="this.closest('div').querySelector('select').selectedIndex = 0; this.closest('div').querySelector('select').dispatchEvent(new Event('change'))"
                            class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition-all hover:scale-105 shadow-lg">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Clear Filters
                        </button>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- Edit Modal -->
    @if($showEditModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-black/75 backdrop-blur-sm transition-opacity" wire:click="closeEditModal"></div>

                <!-- Modal panel -->
                <div class="inline-block align-bottom bg-gray-900 border border-gray-800 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form wire:submit.prevent="updateProduct">
                        <div class="bg-gradient-to-r from-orange-500/10 to-emerald-500/10 px-6 py-4 border-b border-gray-800">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg leading-6 font-semibold text-white">
                                    Edit Product
                                </h3>
                                <button type="button" wire:click="closeEditModal" class="text-gray-400 hover:text-white transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="p-6 space-y-4">
                            <!-- Product Name -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-300">Product Name</label>
                                <input 
                                    type="text" 
                                    wire:model="editName"
                                    class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all"
                                >
                                @error('editName') <span class="text-red-400 text-sm flex items-center mt-1">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </span> @enderror
                            </div>

                            <!-- Category -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-300">Category</label>
                                <select wire:model="editCategory" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category }}">{{ $category }}</option>
                                    @endforeach
                                </select>
                                @error('editCategory') <span class="text-red-400 text-sm flex items-center mt-1">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </span> @enderror
                            </div>

                            <!-- Price -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-300">Price (Rs)</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-3 text-gray-400 font-medium">Rs</span>
                                    <input 
                                        type="number" 
                                        step="0.01"
                                        wire:model="editPrice"
                                        class="w-full pl-12 pr-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all"
                                    >
                                </div>
                                @error('editPrice') <span class="text-red-400 text-sm flex items-center mt-1">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </span> @enderror
                            </div>

                            <!-- Product Image -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-300">Product Image</label>
                                @if($currentImage)
                                    <div class="mb-3 p-3 bg-gray-800/50 rounded-lg border border-gray-700">
                                        <img src="{{ Storage::url($currentImage) }}" alt="Current" class="h-20 w-20 object-cover rounded-lg border border-gray-600">
                                        <p class="text-sm text-gray-400 mt-2">Current image</p>
                                    </div>
                                @endif
                                <input 
                                    type="file" 
                                    wire:model="editImage"
                                    accept="image/*"
                                    class="w-full text-sm text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-500 file:text-white hover:file:bg-orange-600 file:transition-colors"
                                >
                                @error('editImage') <span class="text-red-400 text-sm flex items-center mt-1">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </span> @enderror
                                
                                @if ($editImage)
                                    <div class="mt-3 p-3 bg-gray-800/50 rounded-lg border border-gray-700">
                                        <img src="{{ $editImage->temporaryUrl() }}" alt="Preview" class="h-20 w-20 object-cover rounded-lg border border-gray-600">
                                        <p class="text-sm text-gray-400 mt-2">New image preview</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Description -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-300">Description</label>
                                <textarea 
                                    wire:model="editDescription"
                                    rows="3"
                                    class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all resize-none"
                                ></textarea>
                                @error('editDescription') <span class="text-red-400 text-sm flex items-center mt-1">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </span> @enderror
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="bg-gray-800/50 px-6 py-4 border-t border-gray-700 flex flex-col sm:flex-row gap-3 sm:justify-end">
                            <button 
                                type="button"
                                wire:click="closeEditModal"
                                class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white font-semibold rounded-lg transition-all"
                            >
                                Cancel
                            </button>
                            <button 
                                type="submit"
                                class="px-6 py-2 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-semibold rounded-lg transition-all hover:scale-105 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 focus:ring-offset-gray-900"
                                wire:loading.attr="disabled"
                            >
                                <span wire:loading.remove class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Update Product
                                </span>
                                <span wire:loading class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Updating...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>