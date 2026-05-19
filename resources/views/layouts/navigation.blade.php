<nav class="bg-sky-900/80 backdrop-blur-xl border-b border-sky-700/30 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-8">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                    <div class="w-9 h-9 bg-gradient-to-br from-accent-400 to-accent-600 rounded-lg flex items-center justify-center shadow-lg shadow-accent-500/20 group-hover:shadow-accent-500/40 transition-shadow duration-300">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </div>
                    <span class="text-lg font-bold text-white tracking-tight">Sky<span class="text-accent">Weave</span></span>
                </a>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center gap-1">
                    <a href="{{ route('dashboard') }}"
                       class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Dashboard
                        </span>
                    </a>
                    <a href="{{ route('waypoints.index') }}"
                       class="nav-link {{ request()->routeIs('waypoints.*') ? 'active' : '' }}">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Waypoints
                        </span>
                    </a>
                    <a href="{{ route('navaids.index') }}"
                       class="nav-link {{ request()->routeIs('navaids.*') ? 'active' : '' }}">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.348 14.651a3.75 3.75 0 010-5.303m5.304 0a3.75 3.75 0 010 5.303m-7.425 2.122a6.75 6.75 0 010-9.546m9.546 0a6.75 6.75 0 010 9.546M5.106 18.894c-3.808-3.808-3.808-9.98 0-13.788m13.788 0c3.808 3.808 3.808 9.98 0 13.788"/>
                            </svg>
                            NAVAIDs
                        </span>
                    </a>
                    <a href="{{ route('routes.index') }}"
                       class="nav-link {{ request()->routeIs('routes.*') ? 'active' : '' }}">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                            ATS Routes
                        </span>
                    </a>
                </div>
            </div>

            <!-- User Dropdown -->
            <div class="hidden md:flex items-center">
                <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                    <button @click="open = !open"
                            class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-sky-300 rounded-lg hover:text-accent hover:bg-sky-800/60 transition-all duration-200">
                        <div class="w-8 h-8 bg-gradient-to-br from-accent-500 to-accent-700 rounded-full flex items-center justify-center text-white text-xs font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <span>{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 glass-card py-2 z-50"
                         style="display: none;">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-sky-300 hover:text-accent hover:bg-sky-800/40 transition-colors">
                            Profile Settings
                        </a>
                        <hr class="my-1 border-sky-700/30">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-sky-300 hover:text-red-400 hover:bg-sky-800/40 transition-colors">
                                Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Mobile Hamburger -->
            <div class="md:hidden flex items-center">
                <button x-data="{ open: false }" @click="$dispatch('toggle-mobile-nav')"
                        class="p-2 text-sky-400 hover:text-accent hover:bg-sky-800/60 rounded-lg transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation -->
    <div x-data="{ open: false }" @toggle-mobile-nav.window="open = !open" x-show="open" x-cloak
         class="md:hidden border-t border-sky-700/30 bg-sky-900/95 backdrop-blur-xl">
        <div class="px-4 py-3 space-y-1">
            <a href="{{ route('dashboard') }}" class="block nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('waypoints.index') }}" class="block nav-link {{ request()->routeIs('waypoints.*') ? 'active' : '' }}">Waypoints</a>
            <a href="{{ route('navaids.index') }}" class="block nav-link {{ request()->routeIs('navaids.*') ? 'active' : '' }}">NAVAIDs</a>
            <a href="{{ route('routes.index') }}" class="block nav-link {{ request()->routeIs('routes.*') ? 'active' : '' }}">ATS Routes</a>
        </div>
        <div class="px-4 py-3 border-t border-sky-700/30">
            <div class="text-sm text-sky-400 mb-2">{{ Auth::user()->name }}</div>
            <a href="{{ route('profile.edit') }}" class="block nav-link">Profile</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left nav-link text-red-400 hover:text-red-300">Sign Out</button>
            </form>
        </div>
    </div>
</nav>
