<x-app-layout>
    @section('title', 'Route — ' . $route->route_name)

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('routes.index') }}" class="text-sky-400 hover:text-accent transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-white">
                        Route <span class="text-gradient">{{ $route->route_name }}</span>
                    </h1>
                    <p class="text-sm text-sky-400 mt-1">ATS route detail & waypoint sequence</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('routes.edit', $route) }}" class="btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </a>
                <form method="POST" action="{{ route('routes.destroy', $route) }}"
                      onsubmit="return confirm('Delete route {{ $route->route_name }}? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete
                    </button>
                </form>
            </div>
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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Left: Route Info Cards --}}
                <div class="lg:col-span-1 space-y-6">
                    {{-- Route Metadata --}}
                    <div class="glass-card p-6">
                        <h3 class="text-sm font-semibold text-sky-300 uppercase tracking-wider mb-4">Route Information</h3>

                        <div class="space-y-4">
                            <div>
                                <span class="text-xs text-sky-500 uppercase tracking-wider">Route Name</span>
                                <p class="text-lg font-mono font-bold text-accent-300 mt-1">{{ $route->route_name }}</p>
                            </div>

                            <div>
                                <span class="text-xs text-sky-500 uppercase tracking-wider">Description</span>
                                <p class="text-sm text-sky-200 mt-1">{{ $route->description ?? 'No description provided.' }}</p>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <span class="text-xs text-sky-500 uppercase tracking-wider">Created By</span>
                                    <p class="text-sm text-sky-200 mt-1">{{ $route->creator->name ?? '—' }}</p>
                                </div>
                                <div>
                                    <span class="text-xs text-sky-500 uppercase tracking-wider">Created</span>
                                    <p class="text-sm text-sky-200 mt-1">{{ $route->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Route Stats --}}
                    <div class="glass-card p-6">
                        <h3 class="text-sm font-semibold text-sky-300 uppercase tracking-wider mb-4">Route Statistics</h3>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-sky-800/40 rounded-xl p-4 text-center">
                                <div class="text-2xl font-bold text-accent-300">{{ $route->waypoints->count() }}</div>
                                <div class="text-xs text-sky-400 uppercase tracking-wider mt-1">Waypoints</div>
                            </div>
                            <div class="bg-sky-800/40 rounded-xl p-4 text-center">
                                <div class="text-2xl font-bold text-route-light">{{ $distance }} NM</div>
                                <div class="text-xs text-sky-400 uppercase tracking-wider mt-1">Distance</div>
                            </div>
                        </div>
                    </div>

                    {{-- Route Path Summary --}}
                    <div class="glass-card p-6">
                        <h3 class="text-sm font-semibold text-sky-300 uppercase tracking-wider mb-4">Route Path</h3>
                        <div class="flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4 text-route flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                            <span class="font-mono text-accent-300 break-all">
                                {{ $route->waypoints->pluck('identifier')->join(' → ') }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Right: Waypoint Sequence Table --}}
                <div class="lg:col-span-2">
                    <div class="glass-card overflow-hidden">
                        <div class="px-6 py-4 border-b border-sky-800/40">
                            <h3 class="text-sm font-semibold text-sky-300 uppercase tracking-wider">
                                Waypoint Sequence
                                <span class="text-accent-400 ml-1">({{ $route->waypoints->count() }} points)</span>
                            </h3>
                        </div>

                        @if ($route->waypoints->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="table-dark">
                                    <thead>
                                        <tr>
                                            <th class="w-16">#</th>
                                            <th>Identifier</th>
                                            <th>Type</th>
                                            <th>Latitude</th>
                                            <th>Longitude</th>
                                            <th>Region</th>
                                            <th class="text-right">Leg Distance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($route->waypoints as $index => $waypoint)
                                            @php
                                                $legDistance = null;
                                                if ($index > 0) {
                                                    $prev = $route->waypoints[$index - 1];
                                                    $earthRadiusNm = 3440.065;
                                                    $dLat = deg2rad($waypoint->latitude - $prev->latitude);
                                                    $dLon = deg2rad($waypoint->longitude - $prev->longitude);
                                                    $a = sin($dLat / 2) * sin($dLat / 2) +
                                                         cos(deg2rad($prev->latitude)) * cos(deg2rad($waypoint->latitude)) *
                                                         sin($dLon / 2) * sin($dLon / 2);
                                                    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
                                                    $legDistance = round($earthRadiusNm * $c, 2);
                                                }
                                            @endphp
                                            <tr>
                                                <td>
                                                    <span class="w-7 h-7 bg-accent-500/20 text-accent-300 text-xs font-bold rounded-lg flex items-center justify-center">
                                                        {{ $waypoint->pivot->sequence_order }}
                                                    </span>
                                                </td>
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
                                                    @if ($legDistance !== null)
                                                        <span class="font-mono text-sm text-route-light">{{ $legDistance }} NM</span>
                                                    @else
                                                        <span class="text-sky-600 text-xs">Origin</span>
                                                    @endif
                                                </td>
                                            </tr>

                                            {{-- Connector arrow between waypoints --}}
                                            @if (!$loop->last)
                                                <tr class="border-none">
                                                    <td colspan="7" class="py-0 px-6">
                                                        <div class="flex items-center gap-2 pl-2 text-sky-600">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                                            </svg>
                                                            <span class="text-xs">{{ $route->waypoints[$index + 1]->identifier ?? '' }}</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{-- Total Distance Footer --}}
                            <div class="px-6 py-4 border-t border-sky-800/40 bg-sky-800/20">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-sky-400">Total Route Distance</span>
                                    <span class="text-lg font-bold font-mono text-route-light">{{ $distance }} NM</span>
                                </div>
                            </div>
                        @else
                            <div class="p-12 text-center">
                                <p class="text-sky-400 text-sm">No waypoints in this route.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
