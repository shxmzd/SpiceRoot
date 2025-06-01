<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:from-red-700 hover:to-red-800 active:from-red-800 active:to-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-gray-800 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-red-500/25']) }}>
    {{ $slot }}
</button>
