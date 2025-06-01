<x-guest-layout>
    <!-- Header -->
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-bold text-white mb-2" style="font-family: 'Cinzel', serif;">Reset Password</h2>
        <p class="text-gray-400">Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</p>
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

    <!-- Reset Form -->
    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Field -->
        <div>
            <x-label for="email" value="{{ __('Email') }}" class="block text-sm font-medium text-gray-300 mb-2" />
            <x-input id="email" 
                   type="email" 
                   name="email" 
                   :value="old('email')" 
                   required 
                   autofocus 
                   autocomplete="username"
                   class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700/50 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all backdrop-blur-sm" />
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-center pt-4">
            <x-button class="btn-3d text-white font-semibold py-3 px-8 rounded-lg transition-all hover:scale-105 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 focus:ring-offset-transparent w-full">
                {{ __('EMAIL PASSWORD RESET LINK') }}
            </x-button>
        </div>
    </form>

    <!-- Back to Login Link -->
    <div class="mt-8 pt-6 border-t border-orange-500/20">
        <p class="text-center text-sm text-gray-400">
            Remember your password?
            <a href="{{ route('login') }}" 
               class="text-orange-500 hover:text-orange-400 font-medium transition-colors">
                Back to Login
            </a>
        </p>
    </div>
</x-guest-layout>
