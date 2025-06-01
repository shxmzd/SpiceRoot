<x-guest-layout>
    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-white mb-2">Join SpiceHub</h2>
        <p class="text-gray-400">Create your account to start trading premium spices</p>
    </div>

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-500/10 border border-red-500/20 rounded-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-200">Please fix the following errors:</h3>
                    <div class="mt-2 text-sm text-red-300">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Register Form -->
    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name Field -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-300 mb-2">
                Full Name
            </label>
            <input id="name" 
                   type="text" 
                   name="name" 
                   value="{{ old('name') }}"
                   required 
                   autofocus 
                   autocomplete="name"
                   class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all">
        </div>

        <!-- Email Field -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                Email Address
            </label>
            <input id="email" 
                   type="email" 
                   name="email" 
                   value="{{ old('email') }}"
                   required 
                   autocomplete="username"
                   class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all">
        </div>

        <!-- Role Selection -->
        <div>
            <label for="role" class="block text-sm font-medium text-gray-300 mb-2">
                I want to register as
            </label>
            <select id="role" 
                    name="role" 
                    required
                    class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all">
                <option value="">Select your role</option>
                <option value="buyer" {{ old('role') == 'buyer' ? 'selected' : '' }}>
                    🛒 Buyer - I want to purchase spices
                </option>
                <option value="seller" {{ old('role') == 'seller' ? 'selected' : '' }}>
                    🏪 Seller - I want to sell spices
                </option>
            </select>
        </div>

        <!-- Password Field -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-300 mb-2">
                Password
            </label>
            <input id="password" 
                   type="password" 
                   name="password" 
                   required 
                   autocomplete="new-password"
                   class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all">
        </div>

        <!-- Confirm Password Field -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">
                Confirm Password
            </label>
            <input id="password_confirmation" 
                   type="password" 
                   name="password_confirmation" 
                   required 
                   autocomplete="new-password"
                   class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all">
        </div>

        <!-- Terms and Privacy Policy -->
        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
            <div>
                <label for="terms" class="flex items-start space-x-3">
                    <input id="terms" 
                           type="checkbox" 
                           name="terms" 
                           required
                           class="mt-1 h-4 w-4 text-orange-500 bg-gray-800 border-gray-600 rounded focus:ring-orange-500 focus:ring-2">
                    <div class="text-sm text-gray-300 leading-relaxed">
                        I agree to the 
                        <a target="_blank" 
                           href="{{ route('terms.show') }}" 
                           class="text-orange-500 hover:text-orange-400 underline">
                            Terms of Service
                        </a> 
                        and 
                        <a target="_blank" 
                           href="{{ route('policy.show') }}" 
                           class="text-orange-500 hover:text-orange-400 underline">
                            Privacy Policy
                        </a>
                    </div>
                </label>
            </div>
        @endif

        <!-- Register Button -->
        <button type="submit" 
                class="w-full bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-semibold py-3 px-4 rounded-lg transition-all hover:scale-105 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-gray-900">
            Create Account
        </button>
    </form>

    <!-- Login Link -->
    <div class="mt-6 pt-6 border-t border-gray-700">
        <p class="text-center text-sm text-gray-400">
            Already have an account?
            <a href="{{ route('login') }}" 
               class="text-orange-500 hover:text-orange-400 font-medium transition-colors">
                Sign in here
            </a>
        </p>
    </div>
</x-guest-layout>