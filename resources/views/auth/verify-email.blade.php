<x-guest-layout>
    <!-- Header -->
    <div class="mb-6 text-center">
        <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-emerald-500 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-white mb-2">Verify Your Email</h2>
        <p class="text-gray-400">We've sent a verification link to your email address</p>
    </div>

    <!-- Main Message -->
    <div class="mb-6 p-4 bg-blue-500/10 border border-blue-500/20 rounded-lg">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-blue-200">
                    Before continuing, please verify your email address by clicking on the link we just emailed to you. 
                    If you didn't receive the email, we'll gladly send you another.
                </p>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-emerald-200">
                        A new verification link has been sent to your email address!
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Action Buttons -->
    <div class="space-y-4">
        <!-- Resend Email Button -->
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" 
                    class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-semibold py-3 px-4 rounded-lg transition-all hover:scale-105 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 focus:ring-offset-gray-900">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Resend Verification Email
            </button>
        </form>

        <!-- Secondary Actions -->
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('profile.show') }}" 
               class="flex-1 bg-gray-800 hover:bg-gray-700 text-white font-medium py-3 px-4 rounded-lg transition-all text-center border border-gray-700 hover:border-gray-600">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Edit Profile
            </a>

            <form method="POST" action="{{ route('logout') }}" class="flex-1">
                @csrf
                <button type="submit" 
                        class="w-full bg-red-600/20 hover:bg-red-600/30 text-red-400 hover:text-red-300 font-medium py-3 px-4 rounded-lg transition-all border border-red-600/30 hover:border-red-600/50">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Log Out
                </button>
            </form>
        </div>
    </div>

    <!-- Email Tips -->
    <div class="mt-8 p-4 bg-gray-800/50 rounded-lg border border-gray-700">
        <h4 class="text-sm font-semibold text-white mb-2">
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Didn't receive the email?
        </h4>
        <ul class="text-xs text-gray-400 space-y-1 ml-5">
            <li>• Check your spam or junk folder</li>
            <li>• Make sure the email address is correct in your profile</li>
            <li>• Wait a few minutes for the email to arrive</li>
            <li>• Click "Resend" if you still don't see it</li>
        </ul>
    </div>

    <!-- Back to Home -->
    <div class="mt-6 pt-6 border-t border-gray-700">
        <p class="text-center text-sm text-gray-400">
            <a href="/" class="text-emerald-500 hover:text-emerald-400 font-medium transition-colors">
                ← Back to SpiceHub Home
            </a>
        </p>
    </div>
</x-guest-layout>