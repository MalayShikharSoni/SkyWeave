<x-app-layout>
    @section('title', 'ATS Routes')

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-white">ATS Routes</h1>
                <p class="text-sm text-sky-400 mt-1">Air Traffic Service route management</p>
            </div>
            <a href="{{ route('routes.create') }}" class="btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Build Route
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if (session('success'))
                <div class="mb-6 bg-emerald-500/10 border border-emerald-500/20 rounded-xl px-5 py-4 text-sm text-emerald-400 flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Search Bar --}}
            <div class="glass-card p-5 mb-6">
                <form method="GET" action="{{ route('routes.index') }}" class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search by route name..."
                               class="form-input-dark w-full">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="btn-primary">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Search
                        </button>
                        @if (request('search'))
                            <a href="{{ route('routes.index') }}" class="btn-secondary">Clear</a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Routes Table --}}
            <div class="glass-card overflow-hidden">
                @if ($routes->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="table-dark">
                            <thead>
                                <tr>
                                    <th>Route Name</th>
                                    <th>Waypoints</th>
                                    <th>Distance (NM)</th>
                                    <th>Created By</th>
                                    <th>Created</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($routes as $route)
                                    <tr>
                                        <td>
                                            <a href="{{ route('routes.show', $route) }}"
                                               class="font-mono font-bold text-accent-300 hover:text-accent transition-colors">
                                                {{ $route->route_name }}
                                            </a>
                                        </td>
                                        <td>
                                            <span class="text-sky-300">{{ $route->waypoints->count() }} points</span>
                                        </td>
                                        <td>
                                            <span class="font-mono text-route-light">{{ $route->calculateDistance() }} NM</span>
                                        </td>
                                        <td class="text-sky-400">{{ $route->creator->name ?? '—' }}</td>
                                        <td class="text-sky-500 text-sm">{{ $route->created_at->format('d M Y') }}</td>
                                        <td class="text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('routes.show', $route) }}"
                                                   class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-sky-300 bg-sky-800/60 rounded-lg hover:bg-sky-700/60 hover:text-accent transition-all duration-200">
                                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                    View
                                                </a>
                                                <a href="{{ route('routes.edit', $route) }}"
                                                   class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-sky-300 bg-sky-800/60 rounded-lg hover:bg-sky-700/60 hover:text-accent transition-all duration-200">
                                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                    Edit
                                                </a>
                                                <form method="POST" action="{{ route('routes.destroy', $route) }}"
                                                      onsubmit="return confirm('Delete route {{ $route->route_name }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-400 bg-red-500/10 rounded-lg hover:bg-red-500/20 hover:text-red-300 transition-all duration-200">
                                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if ($routes->hasPages())
                        <div class="px-6 py-4 border-t border-sky-800/40">
                            {{ $routes->links() }}
                        </div>
                    @endif
                @else
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 bg-route/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-route" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-1">No ATS routes found</h3>
                        <p class="text-sm text-sky-400 mb-4">
                            @if (request('search'))
                                No routes match your search.
                            @else
                                Build your first ATS route by connecting waypoints.
                            @endif
                        </p>
                        @unless (request('search'))
                            <a href="{{ route('routes.create') }}" class="btn-primary">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                </svg>
                                Build First Route
                            </a>
                        @endunless
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
