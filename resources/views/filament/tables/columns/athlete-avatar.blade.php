@php
    $url = $record->avatar_url ?? null;
    $initials = $record->initials ?? 'NA';
@endphp

<div class="flex items-center justify-center w-10">
    @if ($url)
        <img src="{{ $url }}"
             class="h-10 w-10 rounded-full object-cover
                    ring-1 ring-white/10"
             alt="{{ $record->name }}" />
    @else
        <div class="h-10 w-10 rounded-full grid place-items-center
                    text-sm font-semibold tracking-wide
                    bg-blue-50 text-blue-700 border border-blue-200
                    dark:bg-blue-900/40 dark:text-blue-200 dark:border-blue-700/40">
            {{ $initials }}
        </div>
    @endif
</div>
