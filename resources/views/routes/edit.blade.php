<x-app-layout>
    @section('title', 'Edit Route — ' . $route->route_name)

    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('routes.show', $route) }}" class="text-sky-400 hover:text-accent transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-white">Edit Route</h1>
                <p class="text-sm text-sky-400 mt-1">
                    Modifying <span class="font-mono text-accent-300">{{ $route->route_name }}</span>
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('routes.update', $route) }}" x-data="routeEditor()" x-cloak>
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
                    {{-- Left: Route Details --}}
                    <div class="lg:col-span-2">
                        <div class="glass-card p-6 mb-6">
                            <h3 class="text-sm font-semibold text-sky-300 uppercase tracking-wider mb-4">Route Details</h3>

                            <div class="mb-5">
                                <label for="route_name" class="form-label-dark">
                                    Route Name <span class="text-red-400">*</span>
                                </label>
                                <input type="text" id="route_name" name="route_name"
                                       value="{{ old('route_name', $route->route_name) }}"
                                       class="form-input-dark uppercase" placeholder="e.g. W15" required maxlength="50">
                                @error('route_name')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="description" class="form-label-dark">Description</label>
                                <textarea id="description" name="description" rows="3"
                                          class="form-input-dark" placeholder="Optional route description...">{{ old('description', $route->description) }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Add Waypoint --}}
                        <div class="glass-card p-6">
                            <h3 class="text-sm font-semibold text-sky-300 uppercase tracking-wider mb-4">Add Waypoints</h3>

                            <div class="mb-3">
                                <select x-model="selectedWaypoint" class="form-input-dark w-full">
                                    <option value="">Select a waypoint...</option>
                                    @foreach ($waypoints as $wp)
                                        <option value="{{ $wp->id }}" data-identifier="{{ $wp->identifier }}" data-lat="{{ $wp->latitude }}" data-lon="{{ $wp->longitude }}" data-type="{{ $wp->type }}">
                                            {{ $wp->identifier }} ({{ number_format($wp->latitude, 4) }}°, {{ number_format($wp->longitude, 4) }}°)
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="button" @click="addWaypoint()" :disabled="!selectedWaypoint"
                                    class="btn-primary w-full disabled:opacity-50 disabled:cursor-not-allowed">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                </svg>
                                Add to Route
                            </button>

                            @error('waypoints')
                                <p class="mt-3 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Right: Route Sequence --}}
                    <div class="lg:col-span-3">
                        <div class="glass-card p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-sm font-semibold text-sky-300 uppercase tracking-wider">
                                    Route Sequence
                                    <span x-show="routeWaypoints.length > 0" class="text-accent-400" x-text="'(' + routeWaypoints.length + ' points)'"></span>
                                </h3>
                                <button type="button" @click="clearAll()" x-show="routeWaypoints.length > 0"
                                        class="text-xs text-red-400 hover:text-red-300 transition-colors">
                                    Clear All
                                </button>
                            </div>

                            {{-- Empty State --}}
                            <div x-show="routeWaypoints.length === 0" class="py-12 text-center">
                                <div class="w-14 h-14 bg-route/10 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-7 h-7 text-route" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                    </svg>
                                </div>
                                <p class="text-sky-400 text-sm">Add at least 2 waypoints to build a route</p>
                            </div>

                            {{-- Waypoint List --}}
                            <div x-show="routeWaypoints.length > 0" class="space-y-2">
                                <template x-for="(wp, index) in routeWaypoints" :key="wp.id + '-' + index">
                                    <div class="flex items-center gap-3 bg-sky-800/40 border border-sky-700/30 rounded-xl px-4 py-3 group">
                                        {{-- Sequence Number --}}
                                        <span class="w-7 h-7 bg-accent-500/20 text-accent-300 text-xs font-bold rounded-lg flex items-center justify-center flex-shrink-0"
                                              x-text="index + 1"></span>

                                        {{-- Waypoint Info --}}
                                        <div class="flex-1 min-w-0">
                                            <span class="font-mono font-bold text-accent-300" x-text="wp.identifier"></span>
                                            <span class="text-sky-500 text-xs ml-2" x-text="wp.type"></span>
                                            <div class="text-xs text-sky-500 mt-0.5">
                                                <span class="coord-display text-xs" x-text="parseFloat(wp.latitude).toFixed(4) + '°, ' + parseFloat(wp.longitude).toFixed(4) + '°'"></span>
                                            </div>
                                        </div>

                                        {{-- Move buttons --}}
                                        <div class="flex flex-col gap-0.5 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <button type="button" @click="moveUp(index)" :disabled="index === 0"
                                                    class="p-1 text-sky-400 hover:text-accent disabled:opacity-30 transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/>
                                                </svg>
                                            </button>
                                            <button type="button" @click="moveDown(index)" :disabled="index === routeWaypoints.length - 1"
                                                    class="p-1 text-sky-400 hover:text-accent disabled:opacity-30 transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                                </svg>
                                            </button>
                                        </div>

                                        {{-- Remove --}}
                                        <button type="button" @click="removeWaypoint(index)"
                                                class="p-1.5 text-red-400/60 hover:text-red-400 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>

                                        {{-- Hidden input for form submission --}}
                                        <input type="hidden" name="waypoints[]" :value="wp.id">
                                    </div>
                                </template>

                                {{-- Route path display --}}
                                <div x-show="routeWaypoints.length >= 2" class="mt-4 p-3 bg-sky-800/30 rounded-xl border border-sky-700/20">
                                    <div class="flex items-center gap-2 text-xs text-sky-400">
                                        <svg class="w-4 h-4 text-route" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                        </svg>
                                        Route: <span class="font-mono text-accent-300" x-text="routeWaypoints.map(wp => wp.identifier).join(' → ')"></span>
                                    </div>
                                </div>
                            </div>

                            {{-- Submit --}}
                            <div class="mt-6 flex items-center gap-3" x-show="routeWaypoints.length >= 2">
                                <button type="submit" class="btn-primary">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Update Route
                                </button>
                                <a href="{{ route('routes.show', $route) }}" class="btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function routeEditor() {
            return {
                selectedWaypoint: '',
                routeWaypoints: @json(
                    $route->waypoints->map(fn($wp) => [
                        'id' => $wp->id,
                        'identifier' => $wp->identifier,
                        'latitude' => $wp->latitude,
                        'longitude' => $wp->longitude,
                        'type' => $wp->type,
                    ])->values()
                ),
                waypointData: @json($waypoints->keyBy('id')),

                addWaypoint() {
                    if (!this.selectedWaypoint) return;

                    const id = parseInt(this.selectedWaypoint);
                    const wp = this.waypointData[id];

                    if (!wp) return;

                    this.routeWaypoints.push({
                        id: wp.id,
                        identifier: wp.identifier,
                        latitude: wp.latitude,
                        longitude: wp.longitude,
                        type: wp.type,
                    });

                    this.selectedWaypoint = '';
                },

                removeWaypoint(index) {
                    this.routeWaypoints.splice(index, 1);
                },

                moveUp(index) {
                    if (index === 0) return;
                    const item = this.routeWaypoints.splice(index, 1)[0];
                    this.routeWaypoints.splice(index - 1, 0, item);
                },

                moveDown(index) {
                    if (index === this.routeWaypoints.length - 1) return;
                    const item = this.routeWaypoints.splice(index, 1)[0];
                    this.routeWaypoints.splice(index + 1, 0, item);
                },

                clearAll() {
                    if (confirm('Clear all waypoints from the route?')) {
                        this.routeWaypoints = [];
                    }
                },
            };
        }
    </script>
    @endpush
</x-app-layout>
