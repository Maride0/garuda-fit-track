<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Garuda Fit Track' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-950 text-slate-50">

    {{-- Navbar --}}
    <header 
    x-data="{ open: false }"
    class="border-b border-slate-800 bg-slate-900/60 backdrop-blur-sm"
>
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">

        {{-- Logo kiri --}}
        <div class="flex items-center gap-2">
            <div class="h-7 w-7 rounded-xl bg-emerald-500/90 flex items-center justify-center text-[11px] font-bold">
                GFT
            </div>
            <div class="flex flex-col leading-tight">
                <span class="text-[13px] font-semibold text-slate-50">Garuda Fit Track</span>
                <span class="text-[11px] text-slate-400">Athlete Management System</span>
            </div>
        </div>

        {{-- MENU DESKTOP --}}
        <nav class="hidden md:flex items-center gap-4 text-[13px]">
            <x-nav-link href="/" :active="request()->is('/')">
                Beranda
            </x-nav-link>
            <a href="#features" class="text-slate-300 hover:text-emerald-300 transition">Fitur</a>
            <a href="#modules" class="text-slate-300 hover:text-emerald-300 transition">Modul</a>

            <x-nav-link href="/about" :active="request()->is('about')">
                Tentang
            </x-nav-link>

            <x-nav-link href="/contact" :active="request()->is('contact')">
                Kontak
            </x-nav-link>

            <a href="/admin"
               class="rounded-xl border border-emerald-500/40 bg-emerald-500/10 px-3 py-1.5 text-[12px] font-medium text-emerald-300 hover:bg-emerald-500/20 transition">
                Masuk Panel
            </a>
        </nav>

        {{-- HAMBURGER BUTTON (Mobile) --}}
        <button 
            @click="open = ! open"
            class="md:hidden text-slate-300 hover:text-emerald-300 transition"
        >
            <!-- hamburger icon -->
            <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16" />
            </svg>

            <!-- close icon -->
            <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

    </div>

    {{-- MENU MOBILE DROPDOWN --}}
<div 
    x-show="open"
    x-transition.origin.top
    class="md:hidden border-t border-slate-800 bg-slate-900/80"
>
    @php
        $mobileLinkBase = 'block text-[13px] text-slate-300 hover:text-emerald-300 transition';
    @endphp

    <nav class="px-4 py-3 space-y-3">
        <a href="/" class="{{ $mobileLinkBase }} {{ request()->is('/') ? 'text-emerald-300 font-medium' : '' }}">
            Beranda
        </a>
        <a href="#features" class="{{ $mobileLinkBase }}">Fitur</a>
        <a href="#modules" class="{{ $mobileLinkBase }}">Modul</a>

        <a href="/about"
           class="{{ $mobileLinkBase }} {{ request()->is('about') ? 'text-emerald-300 font-medium' : '' }}">
            Tentang
        </a>

        <a href="/contact"
           class="{{ $mobileLinkBase }} {{ request()->is('contact') ? 'text-emerald-300 font-medium' : '' }}">
            Kontak
        </a>

        <a href="/admin"
           class="block rounded-xl border border-emerald-500/40 bg-emerald-500/10 px-3 py-2 text-[12px] font-medium text-emerald-300 hover:bg-emerald-500/20 transition">
            Masuk Panel
        </a>
    </nav>
</div>

</header>

<body class="min-h-screen bg-slate-950 text-slate-50">

    <!-- {{-- Navbar --}}
    <header class="border-b border-slate-800 bg-slate-900/50 backdrop-blur-sm">
        <div class="max-w-6xl mx-auto px-4 py-4 text-sm flex items-center gap-2">
            <span class="text-emerald-400 font-semibold">GFT</span>
            <span class="text-slate-300">Garuda Fit Track</span>
        </div>
    </header> -->

    {{-- Tempat halaman lain masuk --}}
        <main class="max-w-6xl mx-auto px-4 py-10">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="border-t border-slate-800 bg-slate-950/90">
        <div class="max-w-6xl mx-auto px-4 py-4 text-[11px] text-slate-500 flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
            <span>© {{ now()->year }} Garuda Fit Track.</span>
            <span>Built with Laravel&nbsp;12 &amp; Filament.</span>
        </div>
    </footer>

</body>
</html>

