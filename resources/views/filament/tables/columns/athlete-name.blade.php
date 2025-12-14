@php
    $url = $record->avatar_url ?? null;
    $name = $record->name ?? '-';
    $initials = $record->initials ?? 'NA';
@endphp

<div class="flex items-center gap-3">
    {{-- avatar --}}
    @if ($url)
        <img src="{{ $url }}"
             class="h-9 w-9 rounded-full object-cover ring-1 ring-white/10" />
    @else
        <div class="h-9 w-9 rounded-full grid place-items-center
                    text-sm font-semibold
                    bg-blue-50 text-blue-700
                    dark:bg-blue-900/40 dark:text-blue-200">
            {{ $initials }}
        </div>
    @endif

    {{-- name --}}
    <span class="font-medium text-white dark:text-white">
        {{ $record->name }}
    </span>
</div>
