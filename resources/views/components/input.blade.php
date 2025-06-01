@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'bg-gray-800/50 border-orange-500/30 text-white placeholder-gray-400 focus:border-orange-500 focus:ring-orange-500/50 rounded-md shadow-sm transition-all duration-300 hover:border-orange-500/50']) !!}>
