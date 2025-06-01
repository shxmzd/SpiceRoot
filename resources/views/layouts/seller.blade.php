<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Seller Dashboard</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-black text-white">
        <x-banner />

        <div class="min-h-screen bg-gradient-to-br from-black via-gray-900 to-black">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                {{ $header }}
            @endif

            <!-- Page Content - THIS IS CRUCIAL -->
            <main class="py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    {{ $slot }}
                </div>
            </main>
        </div>

        <!-- Floating Background Elements -->
        <div class="fixed inset-0 pointer-events-none">
            <div class="absolute top-20 left-20 w-32 h-32 bg-gradient-to-br from-orange-500/5 to-emerald-500/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-20 w-40 h-40 bg-gradient-to-br from-emerald-500/5 to-orange-500/5 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-br from-orange-500/3 to-emerald-500/3 rounded-full blur-3xl"></div>
        </div>

        @stack('modals')
        @stack('scripts')
        @livewireScripts
    </body>
</html>