<x-app-layout>
    @section('title', 'Add NAVAID')

    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('navaids.index') }}" class="text-sky-400 hover:text-accent transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-white">Add NAVAID</h1>
                <p class="text-sm text-sky-400 mt-1">Register a new navigation aid</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass-card p-8">
                <form method="POST" action="{{ route('navaids.store') }}">
                    @csrf

                    {{-- Identifier & Name Row --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label for="identifier" class="form-label-dark">
                                Identifier <span class="text-red-400">*</span>
                            </label>
                            <input type="text" id="identifier" name="identifier" value="{{ old('identifier') }}"
                                   class="form-input-dark uppercase" placeholder="e.g. DEL" required maxlength="10">
                            @error('identifier')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="name" class="form-label-dark">
                                Name <span class="text-red-400">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                   class="form-input-dark" placeholder="e.g. Delhi VOR" required maxlength="255">
                            @error('name')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Type & Frequency Row --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label for="type" class="form-label-dark">
                                Type <span class="text-red-400">*</span>
                            </label>
                            <select id="type" name="type" class="form-input-dark" required>
                                @foreach (\App\Models\Navaid::TYPES as $t)
                                    <option value="{{ $t }}" {{ old('type') == $t ? 'selected' : '' }}>
                                        {{ str_replace('_', '/', $t) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="frequency" class="form-label-dark">Frequency (MHz)</label>
                            <input type="number" id="frequency" name="frequency" value="{{ old('frequency') }}"
                                   class="form-input-dark" placeholder="e.g. 116.10" step="0.01" min="0" max="999.99">
                            <p class="mt-1 text-xs text-sky-500">Optional — enter in MHz</p>
                            @error('frequency')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Coordinates Row --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-8">
                        <div>
                            <label for="latitude" class="form-label-dark">
                                Latitude <span class="text-red-400">*</span>
                            </label>
                            <input type="number" id="latitude" name="latitude" value="{{ old('latitude') }}"
                                   class="form-input-dark" placeholder="e.g. 28.5665000" step="0.0000001"
                                   min="-90" max="90" required>
                            <p class="mt-1 text-xs text-sky-500">Decimal degrees (−90 to 90)</p>
                            @error('latitude')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="longitude" class="form-label-dark">
                                Longitude <span class="text-red-400">*</span>
                            </label>
                            <input type="number" id="longitude" name="longitude" value="{{ old('longitude') }}"
                                   class="form-input-dark" placeholder="e.g. 77.1031000" step="0.0000001"
                                   min="-180" max="180" required>
                            <p class="mt-1 text-xs text-sky-500">Decimal degrees (−180 to 180)</p>
                            @error('longitude')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-3">
                        <button type="submit" class="btn-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            Create NAVAID
                        </button>
                        <a href="{{ route('navaids.index') }}" class="btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
