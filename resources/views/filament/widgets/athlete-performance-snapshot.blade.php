@php
    /**
     * Build sparkline SVG points from numeric array.
     */
    $sparkPoints = function (array $values, int $w = 240, int $h = 36) {
        $values = array_values(array_filter($values, fn ($v) => $v !== null && $v !== ''));
        if (count($values) < 2) return '';

        $min = min($values);
        $max = max($values);
        $range = ($max - $min) ?: 1;

        $n = count($values);
        $stepX = $w / max($n - 1, 1);

        $pts = [];
        foreach ($values as $i => $v) {
            $x = $i * $stepX;
            $y = $h - ((($v - $min) / $range) * $h);
            $pts[] = round($x, 2) . ',' . round($y, 2);
        }
        return implode(' ', $pts);
    };
@endphp

<x-filament-widgets::widget>
    <x-filament::section class="gft-section-card">
        {{-- Header --}}
        <div class="flex items-end justify-between">
            <div>
                <h2 class="text-lg font-semibold !text-[#001C8E] dark:!text-blue-200">
                    Athlete Performance Snapshot
                    <span class="mt-2 block h-1 w-16 rounded-full bg-[#A52828]"></span>
                </h2>
            </div>
        </div>
  
        {{-- Horizontal scroll row --}}
        <div class="mt-5 overflow-x-auto gft-hscroll">
            <div class="flex gap-5 min-w-max pb-2">
                @foreach ($this->getSnapshots() as $item)
                    @php
                        $trend = $item['trend'] ?? 'stable';
                        $delta = $item['delta'] ?? null;

                        $spark = $item['spark'] ?? [];
                        $poly = $sparkPoints($spark);

                        $badgeClass = match($trend) {
                            'up' => 'bg-emerald-50 text-emerald-700',
                            'down' => 'bg-rose-50 text-rose-700',
                            default => 'bg-gray-100 text-gray-700',
                        };

                        $lineClass = match($trend) {
                            'up' => 'stroke-emerald-500',
                            'down' => 'stroke-rose-500',
                            default => 'stroke-gray-400',
                        };

                        $barClass = match($trend) {
                            'up' => 'bg-emerald-200',
                            'down' => 'bg-rose-200',
                            default => 'bg-gray-200',
                        };
                    @endphp

                    <div class="rounded-xl
                        bg-gray-50 dark:bg-zinc-900/60
                        border border-gray-100 dark:border-white/10
                        p-3">
                        {{-- top identity --}}
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-full grid place-items-center
                                        bg-blue-50 dark:bg-blue-900/40
                                        border border-blue-200 dark:border-blue-700/40
                                        text-blue-700 dark:text-blue-200
                                        text-sm font-semibold">
                                {{ $item['initials'] }}
                            </div>


                            <div class="min-w-0">
                                <div class="font-semibold !text-[#001C8E] dark:!text-blue-200 truncate">
                                    {{ $item['name'] }}
                                </div>


                                <div class="text-xs text-gray-500 dark:text-zinc-400 truncate">
                                    {{ $item['sport'] }}
                                </div>
                            </div>
                        </div>

                        {{-- metric label --}}
                        <div class="mt-4 text-xs text-gray-500 dark:text-zinc-400">
                            {{ $item['metric_label'] }}
                        </div>
                        {{-- value + badge --}}
                        <div class="mt-1 flex items-center justify-between">
                            <div class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                            {{ $item['metric_value'] }}
                        </div>

                            <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $badgeClass }}">
                                {{ $delta === null ? '—' : (($delta > 0 ? '+' : '') . $delta . '%') }}
                            </span>
                        </div>

                        {{-- sparkline --}}
                        @php
                            // fallback visual biar selalu ada garis (Figma-style)
                            $sparkData = count($item['spark']) >= 2
                                ? $item['spark']
                                : [60, 62, 61, 63, 64, 66, 68];

                            $poly = collect($sparkData)
                                ->map(fn ($v, $i) =>
                                    ($i * (240 / max(count($sparkData) - 1, 1))) . ',' .
                                    (36 - ($v - min($sparkData)) * 0.6)
                                )
                                ->implode(' ');

                            // side accent gradient (status-based, default green)
                            $bar = match($item['trend'] ?? 'up') {
                                'down' => 'bg-gradient-to-b from-rose-200 via-rose-400 to-rose-500',
                                'stable' => 'bg-gradient-to-b from-gray-200 via-gray-300 to-gray-400',
                                default => 'bg-gradient-to-b from-emerald-200 via-emerald-400 to-emerald-500',
                            };
                        @endphp

                        <div class="relative w-[320px] rounded-2xl 
                            bg-white dark:bg-zinc-900
                            border border-gray-100 dark:border-white/10
                            p-5 shadow-sm">
                            {{-- vertical side accent (KESAMPING, BUKAN KE BAWAH) --}}
                            <div class="absolute top-5 bottom-5 right-3 w-1 rounded-full ..."></div>

                            {{-- sparkline canvas --}}
                            <div class="rounded-xl
                                bg-gray-50 dark:bg-zinc-800/60
                                border border-gray-100 dark:border-white/10
                                p-3">
                                <svg viewBox="0 0 240 36" class="w-full h-9">
                                    <polyline
                                        fill="none"
                                        stroke-width="2.5"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        points="{{ $poly }}"
                                        class="stroke-emerald-500"
                                    />
                                </svg>
                            </div>
                        </div>
                        {{-- end sparkline --}}

                        {{-- bottom accent bar --}}
                        <div class="mt-4 h-1.5 w-full rounded-full {{ $barClass }}"></div>
                    </div>
                @endforeach
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>