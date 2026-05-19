<x-app-layout>
    @section('title', $title)

    <x-slot name="header">
        <h1 class="text-2xl font-bold text-white">{{ $title }}</h1>
    </x-slot>

    <div class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass-card p-12 text-center">
                <div class="w-16 h-16 bg-accent-500/10 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-accent-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17l-5.35-5.35m12.93 0l-5.35 5.35M3.75 7.5h16.5M3.75 16.5h16.5"/>
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-white mb-2">{{ $title }}</h2>
                <p class="text-sky-400 text-sm max-w-md mx-auto">{{ $description }}</p>
                <div class="mt-6">
                    <span class="inline-flex items-center px-3 py-1.5 text-xs font-mono text-sky-500 bg-sky-800/40 rounded-full border border-sky-700/30">
                        Under Construction
                    </span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
