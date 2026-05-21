<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="SkyWeave — Professional Aviation Route Visualization & ATS Route Management Platform">

        <title>{{ config('app.name', 'SkyWeave') }} — @yield('title', 'Authentication')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-sky-950 bg-aviation-grid relative overflow-hidden">

            {{-- Ambient glow effects --}}
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[400px] bg-accent-500/5 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-0 right-0 w-[300px] h-[300px] bg-accent-600/3 rounded-full blur-3xl pointer-events-none"></div>

            {{-- Logo & Branding --}}
            <div class="mb-8 text-center animate-fade-in">
                <a href="/" class="inline-flex items-center gap-3 group">
                    <div class="w-12 h-12 bg-gradient-to-br from-accent-400 to-accent-600 rounded-xl flex items-center justify-center shadow-lg shadow-accent-500/25 group-hover:shadow-accent-500/40 transition-shadow duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold text-white tracking-tight">Sky<span class="text-accent">Weave</span></span>
                </a>
                <p class="mt-2 text-sm text-sky-500">Aviation Route Management Platform</p>
            </div>

            {{-- Auth Card --}}
            <div class="w-full sm:max-w-md px-8 py-8 glass-card animate-slide-up relative z-10 mx-4">
                {{ $slot }}
            </div>

            {{-- Footer --}}
            <div class="mt-8 text-center text-xs text-sky-600 animate-fade-in">
                <p>&copy; {{ date('Y') }} SkyWeave. Professional Aviation Navigation.</p>
            </div>
        </div>
    </body>
</html>
