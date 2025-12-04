@props([
    'href',
    'active' => false,
])

@php
$baseClasses = 'relative inline-flex items-center px-1 py-0.5 transition';
$activeClasses = 'text-emerald-300 font-medium';
$inactiveClasses = 'text-slate-300 hover:text-emerald-300';
@endphp

<a href="{{ $href }}" 
   {{ $attributes->merge(['class' => $baseClasses . ' ' . ($active ? $activeClasses : $inactiveClasses)]) }}>
    
    {{ $slot }}

    {{-- underline --}}
    <span class="absolute left-0 -bottom-1 w-full h-[2px] rounded bg-emerald-300 transition-all duration-300
                {{ $active ? 'scale-x-100 opacity-100' : 'scale-x-0 opacity-0' }}">
    </span>
</a>
