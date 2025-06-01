<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-3 md:gap-6 profile-card p-6 mb-8']) }}>
    <x-section-title>
        <x-slot name="title">{{ $title }}</x-slot>
        <x-slot name="description">{{ $description }}</x-slot>
    </x-section-title>

    <div class="mt-5 md:mt-0 md:col-span-2">
        <div class="px-4 py-5 sm:p-6 bg-gradient-to-br from-gray-800/50 to-gray-900/50 border border-orange-500/20 sm:rounded-lg">
            {{ $content }}
        </div>
    </div>
</div>
