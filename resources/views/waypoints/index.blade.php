<x-app-layout>
    @section('title', 'Waypoints')

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-white">Waypoints</h1>
                <p class="text-sm text-sky-400 mt-1">Manage aviation navigation fixes</p>
            </div>
            <a href="{{ route('waypoints.create') }}" class="btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Add Waypoint
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

            {{-- Search & Filter Bar --}}
            <div class="glass-card p-5 mb-6">
                <form method="GET" action="{{ route('waypoints.index') }}" class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search by identifier or region..."
                               class="form-input-dark w-full">
                    </div>
                    <div class="sm:w-48">
                        <select name="type" class="form-input-dark w-full">
                            <option value="">All Types</option>
                            @foreach (['FIX', 'RNAV', 'VFR', 'IFR'] as $t)
                                <option value="{{ $t }}" {{ request('type') == $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="btn-primary">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Search
                        </button>
                        @if (request('search') || request('type'))
                            <a href="{{ route('waypoints.index') }}" class="btn-secondary">Clear</a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Waypoints Table --}}
            <div class="glass-card overflow-hidden">
                @if ($waypoints->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="table-dark">
                            <thead>
                                <tr>
                                    <th>Identifier</th>
                                    <th>Type</th>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                    <th>Region</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($waypoints as $waypoint)
                                    <tr>
                                        <td>
                                            <span class="font-mono font-bold text-accent-300">{{ $waypoint->identifier }}</span>
                                        </td>
                                        <td>
                                            <span class="badge-fix">{{ $waypoint->type }}</span>
                                        </td>
                                        <td>
                                            <span class="coord-display">{{ number_format($waypoint->latitude, 7) }}°</span>
                                        </td>
                                        <td>
                                            <span class="coord-display">{{ number_format($waypoint->longitude, 7) }}°</span>
                                        </td>
                                        <td class="text-sky-400">{{ $waypoint->region ?? '—' }}</td>
                                        <td class="text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('waypoints.edit', $waypoint) }}"
                                                   class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-sky-300 bg-sky-800/60 rounded-lg hover:bg-sky-700/60 hover:text-accent transition-all duration-200">
                                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                    Edit
                                                </a>
                                                <form method="POST" action="{{ route('waypoints.destroy', $waypoint) }}"
                                                      onsubmit="return confirm('Delete waypoint {{ $waypoint->identifier }}?')">
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

                    {{-- Pagination --}}
                    @if ($waypoints->hasPages())
                        <div class="px-6 py-4 border-t border-sky-800/40">
                            {{ $waypoints->links() }}
                        </div>
                    @endif
                @else
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 bg-accent-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-accent-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-1">No waypoints found</h3>
                        <p class="text-sm text-sky-400 mb-4">
                            @if (request('search') || request('type'))
                                No waypoints match your current filters.
                            @else
                                Get started by adding your first navigation fix.
                            @endif
                        </p>
                        @unless (request('search') || request('type'))
                            <a href="{{ route('waypoints.create') }}" class="btn-primary">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                </svg>
                                Add First Waypoint
                            </a>
                        @endunless
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
