@props([
    'title' => '',     // judul kecil di atas
])

<div {{ $attributes->merge([
    'class' => 'rounded-2xl border border-emerald-500/60 bg-slate-900/80 p-4 space-y-2'

]) }}>
    @if ($title)
        <p class="text-xs font-semibold text-emerald-300 uppercase tracking-wide">
            {{ $title }}
        </p>
    @endif

    <div class="text-slate-100 text-sm">
        {{ $slot }}
    </div>
</div>
