<x-guest-layout>
    <!-- Header -->
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-bold text-white mb-2" style="font-family: 'Cinzel', serif;">Two-Factor Authentication</h2>
        <p class="text-gray-400">Secure your SpiceHub account</p>
    </div>

    <!-- Validation Errors -->
    <x-validation-errors class="mb-4" />

    <div x-data="{ recovery: false }">
        <div class="mb-6 text-sm text-gray-300 text-center" x-show="! recovery">
            {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
        </div>

        <div class="mb-6 text-sm text-gray-300 text-center" x-cloak x-show="recovery">
            {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
        </div>

        <form method="POST" action="{{ route('two-factor.login') }}" class="space-y-6">
            @csrf

            <div x-show="! recovery">
                <x-label for="code" value="{{ __('Code') }}" class="block text-sm font-medium text-gray-300 mb-2" />
                <x-input id="code" 
                       type="text" 
                       inputmode="numeric" 
                       name="code" 
                       autofocus 
                       x-ref="code" 
                       autocomplete="one-time-code"
                       class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700/50 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all backdrop-blur-sm" />
            </div>

            <div x-cloak x-show="recovery">
                <x-label for="recovery_code" value="{{ __('Recovery Code') }}" class="block text-sm font-medium text-gray-300 mb-2" />
                <x-input id="recovery_code" 
                       type="text" 
                       name="recovery_code" 
                       x-ref="recovery_code" 
                       autocomplete="one-time-code"
                       class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700/50 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all backdrop-blur-sm" />
            </div>

            <div class="flex items-center justify-between pt-4">
                <div class="flex space-x-4">
                    <button type="button" 
                            class="text-sm text-gray-400 hover:text-orange-500 transition-colors underline cursor-pointer"
                            x-show="! recovery"
                            x-on:click="
                                recovery = true;
                                $nextTick(() => { $refs.recovery_code.focus() })
                            ">
                        {{ __('Use a recovery code') }}
                    </button>

                    <button type="button" 
                            class="text-sm text-gray-400 hover:text-orange-500 transition-colors underline cursor-pointer"
                            x-cloak
                            x-show="recovery"
                            x-on:click="
                                recovery = false;
                                $nextTick(() => { $refs.code.focus() })
                            ">
                        {{ __('Use an authentication code') }}
                    </button>
                </div>

                <x-button class="btn-3d text-white font-semibold py-3 px-8 rounded-lg transition-all hover:scale-105 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 focus:ring-offset-transparent">
                    {{ __('LOG IN') }}
                </x-button>
            </div>
        </form>
    </div>
</x-guest-layout>
