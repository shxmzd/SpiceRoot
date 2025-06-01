<div class="bg-black min-h-screen text-white">
    
    <div class="bg-gradient-to-r from-gray-900 to-black border-b border-gray-800">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-orange-500 to-emerald-500 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Expand your spice collection</p>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                    <a href="{{ route('seller.products.view') }}" 
                       class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition-all hover:scale-105 shadow-lg">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        View Products
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

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <!-- Left Column: Form -->
                <div class="bg-gray-900/50 backdrop-blur-xl border border-gray-800 rounded-2xl shadow-2xl overflow-hidden">
                    <div class="bg-gradient-to-r from-orange-500/10 to-emerald-500/10 p-6 border-b border-gray-800">
                        <h3 class="text-2xl font-bold text-white mb-2 text-center">Craft Your Product</h3>
                        <p class="text-gray-400 text-center">Create a premium spice listing</p>
                    </div>
                    
                    <div class="p-8">
                        <form wire:submit.prevent="addProduct" enctype="multipart/form-data" class="space-y-6">
                            
                            <!-- Product Name -->
                            <div class="space-y-2">
                                <label for="name" class="block text-sm font-semibold text-gray-300">Product Name</label>
                                <input 
                                    type="text" 
                                    id="name"
                                    wire:model.live="name" 
                                    placeholder="e.g., Premium Kashmir Saffron"
                                    class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all"
                                >
                                @error('name') <span class="text-red-400 text-sm flex items-center mt-1">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </span> @enderror
                            </div>

                            <!-- Category -->
                            <div class="space-y-2">
                                <label for="category" class="block text-sm font-semibold text-gray-300">Category</label>
                                <select 
                                    id="category"
                                    wire:model.live="category"
                                    class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all"
                                >
                                    <option value="">Select Category</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat }}">{{ $cat }}</option>
                                    @endforeach
                                </select>
                                @error('category') <span class="text-red-400 text-sm flex items-center mt-1">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </span> @enderror
                            </div>

                            <!-- Price -->
                            <div class="space-y-2">
                                <label for="price" class="block text-sm font-semibold text-gray-300">Price (Rs)</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-3 text-gray-400 font-medium">Rs</span>
                                    <input 
                                        type="number" 
                                        id="price"
                                        wire:model.live="price" 
                                        step="0.01"
                                        placeholder="29.99"
                                        class="w-full pl-12 pr-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all"
                                    >
                                </div>
                                @error('price') <span class="text-red-400 text-sm flex items-center mt-1">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </span> @enderror
                            </div>

                            <!-- Product Image -->
                            <div class="space-y-2">
                                <label for="image" class="block text-sm font-semibold text-gray-300">Product Image</label>
                                <div class="border-2 border-dashed border-gray-700 rounded-lg p-6 hover:border-orange-500 transition-all duration-200 bg-gray-800/50">
                                    <input 
                                        type="file" 
                                        id="image"
                                        wire:model.live="image" 
                                        accept="image/*"
                                        class="w-full text-sm text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-500 file:text-white hover:file:bg-orange-600 file:transition-colors cursor-pointer"
                                    >
                                    <div class="mt-2 text-center">
                                        <svg class="w-8 h-8 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-sm text-gray-400 mt-1">Upload your spice image</p>
                                    </div>
                                </div>
                                @error('image') <span class="text-red-400 text-sm flex items-center mt-1">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </span> @enderror
                                
                                <!-- Image Preview in Form -->
                                @if ($image)
                                    <div class="mt-3 p-2 bg-gray-800 rounded-lg border border-gray-700">
                                        <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="h-24 w-24 object-cover rounded-lg mx-auto border border-gray-600">
                                        <p class="text-center text-sm text-gray-400 mt-2">Preview</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Description -->
                            <div class="space-y-2">
                                <label for="description" class="block text-sm font-semibold text-gray-300">Description</label>
                                <textarea 
                                    id="description"
                                    wire:model.live="description" 
                                    rows="4"
                                    placeholder="Describe your premium spice - its origin, flavor profile, and what makes it special..."
                                    class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all resize-none"
                                ></textarea>
                                @error('description') <span class="text-red-400 text-sm flex items-center mt-1">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </span> @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="pt-4">
                                <button 
                                    type="submit" 
                                    class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold py-4 px-6 rounded-xl transform hover:scale-105 transition-all shadow-lg hover:shadow-orange-500/25 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 focus:ring-offset-gray-900"
                                    wire:loading.attr="disabled"
                                >
                                    <span wire:loading.remove class="flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        🌶️ Add to Collection
                                    </span>
                                    <span wire:loading class="flex items-center justify-center">
                                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Adding Product...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Right Column: Live Preview -->
                <div class="bg-gray-900/50 backdrop-blur-xl border border-gray-800 rounded-2xl shadow-2xl overflow-hidden sticky top-8">
                    <div class="bg-gradient-to-r from-emerald-500/10 to-orange-500/10 p-6 border-b border-gray-800">
                        <h3 class="text-2xl font-bold text-white mb-2 text-center">Live Preview</h3>
                        <p class="text-gray-400 text-center">See how customers will view your product</p>
                    </div>
                    
                    <div class="p-8">
                        <!-- Product Card Preview -->
                        <div class="max-w-sm mx-auto bg-gray-800/70 backdrop-blur-sm border border-gray-700 rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 transition-all duration-300 hover:shadow-2xl">
                            
                            <!-- Product Image -->
                            <div class="h-48 bg-gray-700 flex items-center justify-center relative overflow-hidden">
                                @if ($image)
                                    <img src="{{ $image->temporaryUrl() }}" alt="Product" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                                @else
                                    <div class="text-center text-gray-400">
                                        <svg class="w-16 h-16 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-sm opacity-75">Product Image</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Product Details -->
                            <div class="p-6">
                                <!-- Product Name -->
                                <h4 class="text-xl font-bold text-white mb-2">
                                    {{ $name ?: 'Product Name' }}
                                </h4>

                                <!-- Description -->
                                <p class="text-gray-300 text-sm mb-4 line-clamp-3 leading-relaxed">
                                    {{ $description ?: 'Product description will appear here. Describe the unique qualities, origin, and flavor profile of your premium spice...' }}
                                </p>

                                <!-- Price and Category -->
                                <div class="flex justify-between items-center mb-4">
                                    <span class="text-2xl font-bold bg-gradient-to-r from-orange-400 to-emerald-400 bg-clip-text text-transparent">
                                        {{ $this->formattedPrice }}
                                    </span>
                                    @if($category)
                                        <span class="inline-block bg-orange-500/20 text-orange-400 border border-orange-500/30 text-xs px-3 py-1 rounded-full font-semibold">
                                            {{ $category }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Action Buttons -->
                                <div class="space-y-2">
                                    <button class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-semibold py-3 px-4 rounded-lg transition-all hover:scale-105 shadow-lg">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.293 2.293A1 1 0 005 16h9m-9 0a2 2 0 104 0M19 16a2 2 0 11-4 0"></path>
                                        </svg>
                                        Add to Cart
                                    </button>
                                    <button class="w-full bg-gray-700 hover:bg-gray-600 text-gray-300 hover:text-white font-semibold py-3 px-4 rounded-lg transition-all border border-gray-600 hover:border-gray-500">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                        Add to Wishlist
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Preview Info -->
                        <div class="mt-6 text-center">
                            <div class="inline-flex items-center px-4 py-2 bg-gray-800/50 border border-gray-700 rounded-lg">
                                <svg class="w-4 h-4 text-emerald-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-sm text-gray-400">
                                    Customer view preview
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>