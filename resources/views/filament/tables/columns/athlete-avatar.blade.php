@php
    $url = $record->avatar_url ?? null;
    $initials = $record->initials ?? 'NA';

    $name = $record->name ?? '-';
    $sport = $record->sport_name ?? ($record->sport ?? null);
@endphp

<div class="flex items-center gap-3">
    <div class="w-10 h-10 shrink-0">
        @if ($url)
            <img src="{{ $url }}"
                 class="h-10 w-10 rounded-full object-cover ring-1 ring-white/10"
                 alt="{{ $name }}">
        @else
            <div class="h-10 w-10 rounded-full grid place-items-center
                        text-sm font-semibold tracking-wide
                        bg-blue-50 text-blue-700 border border-blue-200
                        dark:bg-blue-900/40 dark:text-blue-200 dark:border-blue-700/40">
                {{ $initials }}
            </div>
        @endif
    </div>

    <div class="min-w-0">
        <div class="font-medium truncate text-slate-900 dark:text-white">
            {{ $name }}
        </div>
        @if ($sport)
            <div class="text-xs truncate text-slate-500 dark:text-zinc-400">
                {{ $sport }}
            </div>
        @endif
    </div>
</div>
