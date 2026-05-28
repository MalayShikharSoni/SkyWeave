<x-app-layout>
    @section('title', 'Dashboard')

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-white">Command Center</h1>
                <p class="text-sm text-sky-400 mt-1">Aviation navigation overview</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs font-mono text-sky-500 bg-sky-800/40 px-3 py-1.5 rounded-lg border border-sky-700/30">
                    {{ now()->format('d M Y — H:i') }} UTC
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Banner -->
            <div class="glass-card p-8 mb-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-accent-500/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
                <div class="relative">
                    <h2 class="text-xl font-semibold text-white mb-2">
                        Welcome back, <span class="text-gradient">{{ Auth::user()->name }}</span>
                    </h2>
                    <p class="text-sky-400 text-sm max-w-xl">
                        Your aviation navigation workspace is ready. Manage waypoints, configure NAVAIDs, and build ATS routes with precision.
                    </p>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
                <!-- Waypoints Stat -->
                <div class="stat-card group">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 bg-accent-500/15 rounded-xl flex items-center justify-center group-hover:bg-accent-500/25 transition-colors">
                            <svg class="w-5 h-5 text-accent-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-sky-500 bg-sky-800/40 px-2 py-1 rounded-md">Total</span>
                    </div>
                    <div class="stat-value">{{ \App\Models\Waypoint::count() ?? 0 }}</div>
                    <div class="stat-label">Waypoints</div>
                </div>

                <!-- NAVAIDs Stat -->
                <div class="stat-card group">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 bg-nav-vor/15 rounded-xl flex items-center justify-center group-hover:bg-nav-vor/25 transition-colors">
                            <svg class="w-5 h-5 text-nav-vor" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.348 14.651a3.75 3.75 0 010-5.303m5.304 0a3.75 3.75 0 010 5.303m-7.425 2.122a6.75 6.75 0 010-9.546m9.546 0a6.75 6.75 0 010 9.546"/>
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-sky-500 bg-sky-800/40 px-2 py-1 rounded-md">Active</span>
                    </div>
                    <div class="stat-value">{{ \App\Models\Navaid::count() ?? 0 }}</div>
                    <div class="stat-label">NAVAIDs</div>
                </div>

                <!-- Routes Stat -->
                <div class="stat-card group">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 bg-route/15 rounded-xl flex items-center justify-center group-hover:bg-route/25 transition-colors">
                            <svg class="w-5 h-5 text-route" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-sky-500 bg-sky-800/40 px-2 py-1 rounded-md">Built</span>
                    </div>
                    <div class="stat-value">{{ \App\Models\ATSRoute::count() ?? 0 }}</div>
                    <div class="stat-label">ATS Routes</div>
                </div>

                <!-- User Routes Stat -->
                <div class="stat-card group">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 bg-nav-tacan/15 rounded-xl flex items-center justify-center group-hover:bg-nav-tacan/25 transition-colors">
                            <svg class="w-5 h-5 text-nav-tacan" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-sky-500 bg-sky-800/40 px-2 py-1 rounded-md">Yours</span>
                    </div>
                    <div class="stat-value">{{ \App\Models\ATSRoute::where('created_by', Auth::id())->count() ?? 0 }}</div>
                    <div class="stat-label">Your Routes</div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-8">
                <a href="{{ route('waypoints.create') }}" class="elevated-card p-6 block group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-accent-500/10 rounded-xl flex items-center justify-center group-hover:bg-accent-500/20 transition-colors">
                            <svg class="w-6 h-6 text-accent-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold group-hover:text-accent transition-colors">Add Waypoint</h3>
                            <p class="text-sky-500 text-sm">Create a new navigation fix</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('navaids.create') }}" class="elevated-card p-6 block group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-nav-vor/10 rounded-xl flex items-center justify-center group-hover:bg-nav-vor/20 transition-colors">
                            <svg class="w-6 h-6 text-nav-vor" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold group-hover:text-nav-vor transition-colors">Add NAVAID</h3>
                            <p class="text-sky-500 text-sm">Register a navigation aid</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('routes.create') }}" class="elevated-card p-6 block group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-route/10 rounded-xl flex items-center justify-center group-hover:bg-route/20 transition-colors">
                            <svg class="w-6 h-6 text-route" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold group-hover:text-route transition-colors">Build Route</h3>
                            <p class="text-sky-500 text-sm">Create an ATS route</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Global Aviation Map -->
            <div class="glass-card overflow-hidden">
                <div class="px-6 py-4 border-b border-sky-800/40 flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-sky-300 uppercase tracking-wider flex items-center gap-2">
                        <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        SkyWeave Global Map
                    </h3>
                    
                    <!-- Map Controls (Alpine.js will manage visibility) -->
                    <div class="flex items-center gap-3 text-xs" x-data="{
                        toggleLayer(layer) { window.dispatchEvent(new CustomEvent('toggle-map-layer', {detail: {layer}})); }
                    }">
                        <label class="flex items-center gap-1.5 cursor-pointer text-sky-300 hover:text-white transition-colors">
                            <input type="checkbox" checked @change="toggleLayer('waypoints')" class="form-checkbox bg-sky-800/40 border-sky-600 rounded text-accent focus:ring-accent/50 focus:ring-offset-sky-900 w-3.5 h-3.5">
                            Waypoints
                        </label>
                        <label class="flex items-center gap-1.5 cursor-pointer text-sky-300 hover:text-white transition-colors">
                            <input type="checkbox" checked @change="toggleLayer('navaids')" class="form-checkbox bg-sky-800/40 border-sky-600 rounded text-nav-vor focus:ring-nav-vor/50 focus:ring-offset-sky-900 w-3.5 h-3.5">
                            NAVAIDs
                        </label>
                        <label class="flex items-center gap-1.5 cursor-pointer text-sky-300 hover:text-white transition-colors">
                            <input type="checkbox" checked @change="toggleLayer('routes')" class="form-checkbox bg-sky-800/40 border-sky-600 rounded text-route focus:ring-route/50 focus:ring-offset-sky-900 w-3.5 h-3.5">
                            ATS Routes
                        </label>
                    </div>
                </div>
                
                <div id="dashboard-map" class="w-full h-[500px] bg-sky-950 z-0"></div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function initDashboardMap() {
            // SkyWeave dark theme style matching sky-950 aesthetic
            const darkStyle = [
                { elementType: 'geometry', stylers: [{ color: '#0c1a2e' }] },
                { elementType: 'labels.text.stroke', stylers: [{ color: '#0c1a2e' }] },
                { elementType: 'labels.text.fill', stylers: [{ color: '#4a7ab5' }] },
                { featureType: 'administrative', elementType: 'geometry.stroke', stylers: [{ color: '#1e3a5f' }] },
                { featureType: 'administrative.country', elementType: 'geometry.stroke', stylers: [{ color: '#2d5a8a' }] },
                { featureType: 'administrative.land_parcel', stylers: [{ visibility: 'off' }] },
                { featureType: 'administrative.province', elementType: 'geometry.stroke', stylers: [{ color: '#1e3a5f' }] },
                { featureType: 'landscape', elementType: 'geometry', stylers: [{ color: '#0f2240' }] },
                { featureType: 'poi', stylers: [{ visibility: 'off' }] },
                { featureType: 'road', elementType: 'geometry', stylers: [{ color: '#162d50' }] },
                { featureType: 'road', elementType: 'geometry.stroke', stylers: [{ color: '#1a3460' }] },
                { featureType: 'road', elementType: 'labels', stylers: [{ visibility: 'off' }] },
                { featureType: 'road.highway', elementType: 'geometry', stylers: [{ color: '#1a3a65' }] },
                { featureType: 'transit', stylers: [{ visibility: 'off' }] },
                { featureType: 'water', elementType: 'geometry', stylers: [{ color: '#071525' }] },
                { featureType: 'water', elementType: 'labels.text.fill', stylers: [{ color: '#1a3a5c' }] },
            ];

            const map = new google.maps.Map(document.getElementById('dashboard-map'), {
                center: { lat: 22.0, lng: 79.0 },
                zoom: 5,
                styles: darkStyle,
                disableDefaultUI: false,
                zoomControl: true,
                mapTypeControl: false,
                streetViewControl: false,
                fullscreenControl: false,
                backgroundColor: '#0c1a2e',
            });

            // Layer storage
            const layers = {
                waypoints: [],
                navaids: [],
                routes: [],
            };

            // Toggle logic from checkboxes
            window.addEventListener('toggle-map-layer', (e) => {
                const layerName = e.detail.layer;
                const checkbox = e.target;
                const isChecked = checkbox.checked;

                if (layers[layerName]) {
                    layers[layerName].forEach(item => {
                        item.setMap(isChecked ? map : null);
                    });
                }
            });

            // Helper: create SVG circle icon as data URL
            function createCircleIcon(fillColor, strokeColor, radius, filled = true) {
                const size = radius * 2 + 4;
                const cx = size / 2;
                const cy = size / 2;
                const svg = `<svg xmlns="http://www.w3.org/2000/svg" width="${size}" height="${size}">
                    <circle cx="${cx}" cy="${cy}" r="${radius}" fill="${filled ? fillColor : 'transparent'}" stroke="${strokeColor}" stroke-width="${filled ? 1 : 2}"/>
                </svg>`;
                return {
                    url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(svg),
                    scaledSize: new google.maps.Size(size, size),
                    anchor: new google.maps.Point(cx, cy),
                };
            }

            // Shared InfoWindow (only one open at a time)
            const infoWindow = new google.maps.InfoWindow();

            // Fetch and render Waypoints
            fetch('{{ route("api.map.waypoints") }}')
                .then(res => res.json())
                .then(data => {
                    data.forEach(wp => {
                        const marker = new google.maps.Marker({
                            position: { lat: parseFloat(wp.latitude), lng: parseFloat(wp.longitude) },
                            map: map,
                            icon: createCircleIcon('#38bdf8', '#0ea5e9', 4, true),
                            title: wp.identifier,
                        });

                        marker.addListener('mouseover', () => {
                            infoWindow.setContent(`<div style="font-family:Inter,sans-serif;font-size:12px;color:#e0f2fe;"><b>${wp.identifier}</b><br><span style="color:#8aa4d0">${wp.type}</span></div>`);
                            infoWindow.open(map, marker);
                        });
                        marker.addListener('mouseout', () => infoWindow.close());

                        layers.waypoints.push(marker);
                    });
                });

            // Fetch and render NAVAIDs
            fetch('{{ route("api.map.navaids") }}')
                .then(res => res.json())
                .then(data => {
                    data.forEach(nav => {
                        let color = '#10b981'; // VOR green
                        if (nav.type === 'NDB') color = '#f97316';
                        else if (nav.type === 'TACAN') color = '#ec4899';
                        else if (nav.type === 'DME') color = '#6366f1';

                        const marker = new google.maps.Marker({
                            position: { lat: parseFloat(nav.latitude), lng: parseFloat(nav.longitude) },
                            map: map,
                            icon: createCircleIcon('transparent', color, 6, false),
                            title: nav.identifier,
                        });

                        marker.addListener('mouseover', () => {
                            infoWindow.setContent(`<div style="font-family:Inter,sans-serif;font-size:12px;color:#e0f2fe;"><b>${nav.identifier}</b><br><span style="color:${color}">${nav.type}</span><br><span style="color:#8aa4d0">${nav.name}</span></div>`);
                            infoWindow.open(map, marker);
                        });
                        marker.addListener('mouseout', () => infoWindow.close());

                        layers.navaids.push(marker);
                    });
                });

            // Fetch and render Routes
            fetch('{{ route("api.map.routes") }}')
                .then(res => res.json())
                .then(data => {
                    data.forEach(route => {
                        if (route.waypoints.length < 2) return;

                        const path = route.waypoints.map(wp => ({
                            lat: parseFloat(wp.latitude),
                            lng: parseFloat(wp.longitude),
                        }));

                        const polyline = new google.maps.Polyline({
                            path: path,
                            geodesic: true,
                            strokeColor: '#f59e0b',
                            strokeOpacity: 0.7,
                            strokeWeight: 2,
                            map: map,
                            icons: [{
                                icon: { path: 'M 0,-1 0,1', strokeOpacity: 1, scale: 2 },
                                offset: '0',
                                repeat: '12px',
                            }],
                        });
                        // Make the base line transparent for dash effect
                        polyline.setOptions({ strokeOpacity: 0 });

                        // Add hover tooltip for route name
                        const midIdx = Math.floor(route.waypoints.length / 2);
                        const midPoint = { lat: parseFloat(route.waypoints[midIdx].latitude), lng: parseFloat(route.waypoints[midIdx].longitude) };

                        polyline.addListener('mouseover', (e) => {
                            infoWindow.setContent(`<div style="font-family:Inter,sans-serif;font-size:12px;color:#e0f2fe;"><b>Route ${route.route_name}</b></div>`);
                            infoWindow.setPosition(e.latLng || midPoint);
                            infoWindow.open(map);
                        });
                        polyline.addListener('mouseout', () => infoWindow.close());

                        layers.routes.push(polyline);
                    });
                });
        }

        // Initialize when Google Maps API is loaded
        async function loadDashboardMap() {
            await google.maps.importLibrary("maps");
            await google.maps.importLibrary("marker");
            initDashboardMap();
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', loadDashboardMap);
        } else {
            loadDashboardMap();
        }
    </script>
    @endpush
        </div>
    </div>
</x-app-layout>
