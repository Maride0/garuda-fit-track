@php
    $currentMonth = (int) request('month', now()->month);
    $currentYear  = (int) request('year', now()->year);
@endphp

<x-filament::page>
    <form method="GET" action="{{ request()->url() }}" class="mb-6 flex flex-wrap items-end gap-3">
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">
                Bulan
            </label>
            <select
                name="month"
                class="rounded-lg border border-gray-600 bg-gray-900 px-3 py-2 text-sm text-gray-100"
            >
                @foreach (range(1, 12) as $m)
                    <option
                        value="{{ $m }}"
                        @selected($m === $currentMonth)
                    >
                        {{ \Illuminate\Support\Carbon::create(null, $m, 1)->translatedFormat('F') }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">
                Tahun
            </label>
            <select
                name="year"
                class="rounded-lg border border-gray-600 bg-gray-900 px-3 py-2 text-sm text-gray-100"
            >
                @foreach (range(now()->year - 3, now()->year + 1) as $y)
                    <option
                        value="{{ $y }}"
                        @selected($y === $currentYear)
                    >
                        {{ $y }}
                    </option>
                @endforeach
            </select>
        </div>

        <button
            type="submit"
            class="inline-flex items-center rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-500"
        >
            Terapkan
        </button>
    </form>

    {{-- Widgets dirender otomatis dari getHeaderWidgets() --}}
</x-filament::page>
