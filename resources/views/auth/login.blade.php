<x-guest-layout>
    <!-- Header -->
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-bold text-white mb-2" style="font-family: 'Cinzel', serif;">Welcome Back</h2>
        <p class="text-gray-400">Sign in to your SpiceHub account</p>
    </div>

    <!-- Validation Errors -->
    <x-validation-errors class="mb-4" />

    <!-- Status Message -->
    @session('status')
        <div class="mb-4 p-4 bg-green-500/10 border border-green-500/20 rounded-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-200">{{ $value }}</p>
                </div>
            </div>
        </div>
    @endsession



    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Field -->
        <div>
            <x-label for="email" value="{{ __('Email Address') }}" class="block text-sm font-medium text-gray-300 mb-2" />
            <x-input id="email" 
                   type="email" 
                   name="email" 
                   :value="old('email')"
                   required 
                   autofocus 
                   autocomplete="username"
                   class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700/50 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all backdrop-blur-sm" />
        </div>

        <!-- Password Field -->
        <div>
            <x-label for="password" value="{{ __('Password') }}" class="block text-sm font-medium text-gray-300 mb-2" />
            <x-input id="password" 
                   type="password" 
                   name="password" 
                   required 
                   autocomplete="current-password"
                   class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700/50 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all backdrop-blur-sm" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <x-checkbox id="remember_me" name="remember" class="h-4 w-4 text-orange-500 bg-gray-800/50 border-gray-600/50 rounded focus:ring-orange-500 focus:ring-2" />
            <label for="remember_me" class="ml-2 block text-sm text-gray-300">
                {{ __('Remember me') }}
            </label>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between pt-4">
            @if (Route::has('password.request'))
                <a class="text-sm text-gray-400 hover:text-orange-500 transition-colors" 
                   href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-button class="btn-3d text-white font-semibold py-3 px-8 rounded-lg transition-all hover:scale-105 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 focus:ring-offset-transparent">
                {{ __('LOG IN') }}
            </x-button>
        </div>
    </form>

    <!-- Register Link -->
    <div class="mt-8 pt-6 border-t border-orange-500/20">
        <p class="text-center text-sm text-gray-400">
            Don't have an account?
            <a href="{{ route('register') }}" 
               class="text-orange-500 hover:text-orange-400 font-medium transition-colors">
                Create one here
            </a>
        </p>
    </div>
</x-guest-layout>