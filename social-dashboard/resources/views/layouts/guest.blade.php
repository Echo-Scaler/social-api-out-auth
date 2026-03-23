<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-slate-50">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500">
            <div class="mb-8">
                <a href="/">
                    <x-application-logo class="w-16 h-16 fill-current text-white drop-shadow-lg" />
                </a>
            </div>

            <div class="w-full sm:max-w-md px-8 py-10 bg-white/90 backdrop-blur-xl shadow-2xl border border-white/20 sm:rounded-3xl transition-all duration-300">
                {{ $slot }}
            </div>

            <div class="mt-8 text-white/80 text-sm font-medium">
                &copy; {{ date('Y') }} {{ config('app.name') }} &bull; Premium Analytics
            </div>
        </div>
    </body>
</html>
