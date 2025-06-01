<nav x-data="{ open: false }" class="bg-gray-900/95 backdrop-blur-xl border-b border-gray-800 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                        <img src="{{ asset('images/spiceroot_logo.png') }}" alt="SpiceRoot" class="w-10 h-10 object-contain group-hover:scale-110 transition-transform">
                        <span class="text-xl font-bold text-white group-hover:text-orange-400 transition-colors">SpiceRoot</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-6 sm:-my-px sm:ml-10 sm:flex">
                    @auth
                        @if(auth()->user()->isSeller())
                            <!-- Seller Navigation -->
                            <x-nav-link href="{{ route('seller.dashboard') }}" :active="request()->routeIs('seller.dashboard')" 
                                       class="inline-flex items-center px-4 py-2 border-b-2 {{ request()->routeIs('seller.dashboard') ? 'border-orange-500 text-orange-400' : 'border-transparent text-gray-300 hover:text-orange-400 hover:border-orange-500/50' }} text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none focus:border-orange-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v3H8V5z"></path>
                                </svg>
                                {{ __('Dashboard') }}
                            </x-nav-link>
                           
                            <x-nav-link href="{{ route('seller.products.add') }}" :active="request()->routeIs('seller.products.add')"
                                       class="inline-flex items-center px-4 py-2 border-b-2 {{ request()->routeIs('seller.products.add') ? 'border-orange-500 text-orange-400' : 'border-transparent text-gray-300 hover:text-orange-400 hover:border-orange-500/50' }} text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none focus:border-orange-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                {{ __('Add Product') }}
                            </x-nav-link>
                            
                            <x-nav-link href="{{ route('seller.products.view') }}" :active="request()->routeIs('seller.products.view')"
                                       class="inline-flex items-center px-4 py-2 border-b-2 {{ request()->routeIs('seller.products.view') ? 'border-orange-500 text-orange-400' : 'border-transparent text-gray-300 hover:text-orange-400 hover:border-orange-500/50' }} text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none focus:border-orange-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                {{ __('View Products') }}
                            </x-nav-link>
                            
                            <x-nav-link href="{{ route('seller.orders') }}" :active="request()->routeIs('seller.orders*')"
                                       class="inline-flex items-center px-4 py-2 border-b-2 {{ request()->routeIs('seller.orders*') ? 'border-orange-500 text-orange-400' : 'border-transparent text-gray-300 hover:text-orange-400 hover:border-orange-500/50' }} text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none focus:border-orange-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                {{ __('Orders') }}
                                @php $newOrdersCount = \App\Models\Order::getNewOrdersCount(auth()->id()); @endphp
                                @if($newOrdersCount > 0)
                                    <span class="ml-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-500 rounded-full animate-pulse">
                                        {{ $newOrdersCount }}
                                    </span>
                                @endif
                            </x-nav-link>
                            
                        @elseif(auth()->user()->isBuyer())
                            <!-- Buyer Navigation -->
                            <x-nav-link href="{{ route('buyer.dashboard') }}" :active="request()->routeIs('buyer.dashboard')"
                                       class="inline-flex items-center px-4 py-2 border-b-2 {{ request()->routeIs('buyer.dashboard') ? 'border-emerald-500 text-emerald-400' : 'border-transparent text-gray-300 hover:text-emerald-400 hover:border-emerald-500/50' }} text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none focus:border-emerald-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v3H8V5z"></path>
                                </svg>
                                {{ __('Dashboard') }}
                            </x-nav-link>
                            
                            <x-nav-link href="{{ route('buyer.shop') }}" :active="request()->routeIs('buyer.shop')"
                                       class="inline-flex items-center px-4 py-2 border-b-2 {{ request()->routeIs('buyer.shop') ? 'border-emerald-500 text-emerald-400' : 'border-transparent text-gray-300 hover:text-emerald-400 hover:border-emerald-500/50' }} text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none focus:border-emerald-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                {{ __('Shop') }}
                            </x-nav-link>
                            
                            <x-nav-link href="{{ route('buyer.orders') }}" :active="request()->routeIs('buyer.orders')"
                                       class="inline-flex items-center px-4 py-2 border-b-2 {{ request()->routeIs('buyer.orders') ? 'border-emerald-500 text-emerald-400' : 'border-transparent text-gray-300 hover:text-emerald-400 hover:border-emerald-500/50' }} text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none focus:border-emerald-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                {{ __('My Orders') }}
                            </x-nav-link>
                        @else
                            <!-- Default Navigation -->
                            <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')"
                                       class="inline-flex items-center px-4 py-2 border-b-2 {{ request()->routeIs('dashboard') ? 'border-orange-500 text-orange-400' : 'border-transparent text-gray-300 hover:text-orange-400 hover:border-orange-500/50' }} text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none focus:border-orange-500">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <!-- Buyer Cart and Wishlist Icons -->
                @if(auth()->check() && auth()->user()->isBuyer())
                    <div class="flex items-center space-x-3 mr-6">
                        <!-- Wishlist Icon -->
                        <div class="relative group">
                            <a href="{{ route('buyer.wishlist') }}" 
                               class="relative p-3 text-gray-400 hover:text-red-400 transition-all duration-200 bg-gray-800/50 hover:bg-gray-700/50 rounded-xl backdrop-blur-sm border border-gray-700 hover:border-red-400/50 hover:scale-105">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                
                                @php
                                    $wishlistCount = \App\Models\Wishlist::getWishlistCount(auth()->id());
                                @endphp
                                
                                @if($wishlistCount > 0)
                                    <span class="absolute -top-2 -right-2 bg-gradient-to-r from-red-500 to-red-600 text-white text-xs rounded-full h-6 w-6 flex items-center justify-center font-semibold animate-pulse">
                                        {{ $wishlistCount > 99 ? '99+' : $wishlistCount }}
                                    </span>
                                @endif
                            </a>
                            <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-1 bg-gray-900 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                Wishlist
                            </div>
                        </div>

                        <!-- Cart Icon -->
                        <div class="relative group">
                            <a href="{{ route('buyer.cart') }}" 
                               class="relative p-3 text-gray-400 hover:text-orange-400 transition-all duration-200 bg-gray-800/50 hover:bg-gray-700/50 rounded-xl backdrop-blur-sm border border-gray-700 hover:border-orange-400/50 hover:scale-105">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.293 2.293A1 1 0 005 16h9m-9 0a2 2 0 104 0M19 16a2 2 0 11-4 0"></path>
                                </svg>
                                
                                @php
                                    $cartCount = \App\Models\Cart::getCartCount(auth()->id());
                                @endphp
                                
                                @if($cartCount > 0)
                                    <span class="absolute -top-2 -right-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white text-xs rounded-full h-6 w-6 flex items-center justify-center font-semibold animate-pulse">
                                        {{ $cartCount > 99 ? '99+' : $cartCount }}
                                    </span>
                                @endif
                            </a>
                            <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-1 bg-gray-900 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                Cart
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="ml-3 relative">
                        <x-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-gray-700 text-sm leading-4 font-medium rounded-lg text-gray-300 bg-gray-800 hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 transition ease-in-out duration-150">
                                        {{ Auth::user()->currentTeam->name }}
                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <div class="w-60 bg-gray-800 border border-gray-700">
                                    <!-- Team Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Team') }}
                                    </div>

                                    <!-- Team Settings -->
                                    <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" class="text-gray-300 hover:text-white hover:bg-gray-700">
                                        {{ __('Team Settings') }}
                                    </x-dropdown-link>

                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                        <x-dropdown-link href="{{ route('teams.create') }}" class="text-gray-300 hover:text-white hover:bg-gray-700">
                                            {{ __('Create New Team') }}
                                        </x-dropdown-link>
                                    @endcan

                                    <!-- Team Switcher -->
                                    @if (Auth::user()->allTeams()->count() > 1)
                                        <div class="border-t border-gray-700"></div>
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('Switch Teams') }}
                                        </div>
                                        @foreach (Auth::user()->allTeams() as $team)
                                            <x-switchable-team :team="$team" />
                                        @endforeach
                                    @endif
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endif

                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm border-2 border-gray-700 rounded-full focus:outline-none focus:border-orange-500 transition hover:border-orange-400">
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-gray-700 text-sm leading-4 font-medium rounded-lg text-gray-300 bg-gray-800 hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 transition ease-in-out duration-150">
                                        {{ Auth::user()->name }}
                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400 bg-gray-800 border-b border-gray-700">
                                {{ __('Manage Account') }}
                            </div>

                            <x-dropdown-link href="{{ route('profile.show') }}" class="text-gray-300 hover:text-white hover:bg-gray-700 bg-gray-800 border-none">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    {{ __('Profile') }}
                                </div>
                            </x-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-dropdown-link href="{{ route('api-tokens.index') }}" class="text-gray-300 hover:text-white hover:bg-gray-700 bg-gray-800 border-none">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                        </svg>
                                        {{ __('API Tokens') }}
                                    </div>
                                </x-dropdown-link>
                            @endif

                            <div class="border-t border-gray-700"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <x-dropdown-link href="{{ route('logout') }}"
                                         @click.prevent="$root.submit();" class="text-gray-300 hover:text-red-400 hover:bg-gray-700 bg-gray-800 border-none">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        {{ __('Log Out') }}
                                    </div>
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1 bg-gray-800 border-t border-gray-700">
            @auth
                @if(auth()->user()->isSeller())
                    <!-- Seller Mobile Navigation -->
                    <x-responsive-nav-link href="{{ route('seller.dashboard') }}" :active="request()->routeIs('seller.dashboard')" class="text-gray-300 hover:text-orange-400 hover:bg-gray-700 border-l-4 {{ request()->routeIs('seller.dashboard') ? 'border-orange-500 bg-gray-700' : 'border-transparent' }}">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('seller.products.add') }}" :active="request()->routeIs('seller.products.add')" class="text-gray-300 hover:text-orange-400 hover:bg-gray-700 border-l-4 {{ request()->routeIs('seller.products.add') ? 'border-orange-500 bg-gray-700' : 'border-transparent' }}">
                        {{ __('Add Product') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('seller.products.view') }}" :active="request()->routeIs('seller.products.view')" class="text-gray-300 hover:text-orange-400 hover:bg-gray-700 border-l-4 {{ request()->routeIs('seller.products.view') ? 'border-orange-500 bg-gray-700' : 'border-transparent' }}">
                        {{ __('View Products') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('seller.orders') }}" :active="request()->routeIs('seller.orders*')" class="text-gray-300 hover:text-orange-400 hover:bg-gray-700 border-l-4 {{ request()->routeIs('seller.orders*') ? 'border-orange-500 bg-gray-700' : 'border-transparent' }}">
                        {{ __('Orders') }}
                        @php $newOrdersCount = \App\Models\Order::getNewOrdersCount(auth()->id()); @endphp
                        @if($newOrdersCount > 0) <span class="text-red-400">({{ $newOrdersCount }} new)</span> @endif
                    </x-responsive-nav-link>
                @elseif(auth()->user()->isBuyer())
                    <!-- Buyer Mobile Navigation -->
                    <x-responsive-nav-link href="{{ route('buyer.dashboard') }}" :active="request()->routeIs('buyer.dashboard')" class="text-gray-300 hover:text-emerald-400 hover:bg-gray-700 border-l-4 {{ request()->routeIs('buyer.dashboard') ? 'border-emerald-500 bg-gray-700' : 'border-transparent' }}">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('buyer.shop') }}" :active="request()->routeIs('buyer.shop')" class="text-gray-300 hover:text-emerald-400 hover:bg-gray-700 border-l-4 {{ request()->routeIs('buyer.shop') ? 'border-emerald-500 bg-gray-700' : 'border-transparent' }}">
                        {{ __('Shop') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('buyer.orders') }}" :active="request()->routeIs('buyer.orders')" class="text-gray-300 hover:text-emerald-400 hover:bg-gray-700 border-l-4 {{ request()->routeIs('buyer.orders') ? 'border-emerald-500 bg-gray-700' : 'border-transparent' }}">
                        {{ __('My Orders') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('buyer.cart') }}" :active="request()->routeIs('buyer.cart')" class="text-gray-300 hover:text-emerald-400 hover:bg-gray-700 border-l-4 {{ request()->routeIs('buyer.cart') ? 'border-emerald-500 bg-gray-700' : 'border-transparent' }}">
                        {{ __('Cart') }}
                        @php $cartCount = \App\Models\Cart::getCartCount(auth()->id()); @endphp
                        @if($cartCount > 0) <span class="text-orange-400">({{ $cartCount }})</span> @endif
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('buyer.wishlist') }}" :active="request()->routeIs('buyer.wishlist')" class="text-gray-300 hover:text-emerald-400 hover:bg-gray-700 border-l-4 {{ request()->routeIs('buyer.wishlist') ? 'border-emerald-500 bg-gray-700' : 'border-transparent' }}">
                        {{ __('Wishlist') }}
                        @php $wishlistCount = \App\Models\Wishlist::getWishlistCount(auth()->id()); @endphp
                        @if($wishlistCount > 0) <span class="text-red-400">({{ $wishlistCount }})</span> @endif
                    </x-responsive-nav-link>
                @else
                    <!-- Default Mobile Navigation -->
                    <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" class="text-gray-300 hover:text-orange-400 hover:bg-gray-700 border-l-4 {{ request()->routeIs('dashboard') ? 'border-orange-500 bg-gray-700' : 'border-transparent' }}">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-700 bg-gray-800">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 mr-3">
                        <img class="h-10 w-10 rounded-full object-cover border-2 border-gray-600" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-400">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')" class="text-gray-300 hover:text-white hover:bg-gray-700">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')" class="text-gray-300 hover:text-white hover:bg-gray-700">
                        {{ __('API Tokens') }}
                    </x-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <x-responsive-nav-link href="{{ route('logout') }}"
                                   @click.prevent="$root.submit();" class="text-gray-300 hover:text-white hover:bg-gray-700">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-gray-700"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')" class="text-gray-300 hover:text-white hover:bg-gray-700">
                        {{ __('Team Settings') }}
                    </x-responsive-nav-link>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <x-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')" class="text-gray-300 hover:text-white hover:bg-gray-700">
                            {{ __('Create New Team') }}
                        </x-responsive-nav-link>
                    @endcan

                    <!-- Team Switcher -->
                    @if (Auth::user()->allTeams()->count() > 1)
                        <div class="border-t border-gray-700"></div>

                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Switch Teams') }}
                        </div>

                        @foreach (Auth::user()->allTeams() as $team)
                            <x-responsive-nav-link href="{{ route('teams.switch', $team) }}" x-data class="text-gray-300 hover:text-white hover:bg-gray-700">
                                {{ $team->name }}
                            </x-responsive-nav-link>
                        @endforeach
                    @endif
                @endif
            </div>
        </div>
    </div>
</nav>

