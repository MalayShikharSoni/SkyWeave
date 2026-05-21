<x-app-layout>
    @section('title', 'NAVAIDs')

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-white">NAVAIDs</h1>
                <p class="text-sm text-sky-400 mt-1">Navigation aids registry</p>
            </div>
            <a href="{{ route('navaids.create') }}" class="btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Add NAVAID
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
                <form method="GET" action="{{ route('navaids.index') }}" class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search by identifier or name..."
                               class="form-input-dark w-full">
                    </div>
                    <div class="sm:w-48">
                        <select name="type" class="form-input-dark w-full">
                            <option value="">All Types</option>
                            @foreach (\App\Models\Navaid::TYPES as $t)
                                <option value="{{ $t }}" {{ request('type') == $t ? 'selected' : '' }}>
                                    {{ str_replace('_', '/', $t) }}
                                </option>
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
                            <a href="{{ route('navaids.index') }}" class="btn-secondary">Clear</a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- NAVAIDs Table --}}
            <div class="glass-card overflow-hidden">
                @if ($navaids->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="table-dark">
                            <thead>
                                <tr>
                                    <th>Identifier</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Frequency</th>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($navaids as $navaid)
                                    <tr>
                                        <td>
                                            <span class="font-mono font-bold text-accent-300">{{ $navaid->identifier }}</span>
                                        </td>
                                        <td class="text-sky-200">{{ $navaid->name }}</td>
                                        <td>
                                            @php
                                                $badgeClass = match($navaid->type) {
                                                    'VOR' => 'badge-vor',
                                                    'DME' => 'badge-dme',
                                                    'NDB' => 'badge-ndb',
                                                    'TACAN' => 'badge-tacan',
                                                    'VOR_DME' => 'badge-vor',
                                                    default => 'badge-fix',
                                                };
                                            @endphp
                                            <span class="{{ $badgeClass }}">{{ str_replace('_', '/', $navaid->type) }}</span>
                                        </td>
                                        <td>
                                            @if ($navaid->frequency)
                                                <span class="font-mono text-sm text-sky-300">{{ number_format($navaid->frequency, 2) }} MHz</span>
                                            @else
                                                <span class="text-sky-600">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="coord-display">{{ number_format($navaid->latitude, 7) }}°</span>
                                        </td>
                                        <td>
                                            <span class="coord-display">{{ number_format($navaid->longitude, 7) }}°</span>
                                        </td>
                                        <td class="text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('navaids.edit', $navaid) }}"
                                                   class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-sky-300 bg-sky-800/60 rounded-lg hover:bg-sky-700/60 hover:text-accent transition-all duration-200">
                                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                    Edit
                                                </a>
                                                <form method="POST" action="{{ route('navaids.destroy', $navaid) }}"
                                                      onsubmit="return confirm('Delete NAVAID {{ $navaid->identifier }}?')">
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
                    @if ($navaids->hasPages())
                        <div class="px-6 py-4 border-t border-sky-800/40">
                            {{ $navaids->links() }}
                        </div>
                    @endif
                @else
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 bg-nav-vor/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-nav-vor" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.348 14.651a3.75 3.75 0 010-5.303m5.304 0a3.75 3.75 0 010 5.303m-7.425 2.122a6.75 6.75 0 010-9.546m9.546 0a6.75 6.75 0 010 9.546"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-1">No NAVAIDs found</h3>
                        <p class="text-sm text-sky-400 mb-4">
                            @if (request('search') || request('type'))
                                No NAVAIDs match your current filters.
                            @else
                                Register your first navigation aid to get started.
                            @endif
                        </p>
                        @unless (request('search') || request('type'))
                            <a href="{{ route('navaids.create') }}" class="btn-primary">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                </svg>
                                Add First NAVAID
                            </a>
                        @endunless
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
