@php
    $name = $record->name ?? '-';
    $initial = mb_strtoupper(mb_substr($name, 0, 1));
    $avatarUrl = $record->avatar_url; // return null kalau ga ada foto (sesuai accessor kamu yg baru)
@endphp
<div style="width:36px;height:36px;border-radius:9999px;overflow:hidden;display:flex;align-items:center;justify-content:center;background:#f3f4f6;">
<div
    class="w-9 h-9 rounded-full overflow-hidden shrink-0 ring-1 ring-gray-200 bg-gray-100
           flex items-center justify-center"
>
    @if ($avatarUrl)
        <img
            src="{{ $avatarUrl }}"
            alt="{{ $name }}"
            class="w-full h-full object-cover"
            loading="lazy"
        />
    @else
        <span class="text-sm font-semibold text-gray-700 leading-none">
            {{ $initial }}
        </span>
    @endif
</div>
