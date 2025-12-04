@extends('layouts.app')

@section('content')

<section class="py-6">
    <div class="grid gap-8 md:grid-cols-2 md:items-center">
        {{-- Kiri: teks utama --}}
        <div class="space-y-4">
            <p class="text-xs font-medium uppercase tracking-[0.2em] text-emerald-300">
                Athlete Management • Health • Performance
            </p>

            <h1 class="text-3xl font-semibold tracking-tight">
                Garuda Fit Track
            </h1>

            <p class="text-sm text-slate-300 leading-relaxed max-w-md">
                Sistem manajemen atlet yang menghubungkan data profil, hasil screening,
                jadwal terapi, program latihan, dan pencapaian prestasi dalam satu dashboard.
            </p>

            <div class="flex flex-wrap gap-3 text-xs">
                <x-button href="/admin" variant="primary">
                    Buka Panel Admin
                </x-button>

                <x-button href="#modules" variant="outline">
                    Lihat Modul Sistem
                </x-button>
            </div>

        </div>

        {{-- Kanan: kartu kecil dummy overview --}}
        <div class="rounded-2xl border border-slate-800 bg-slate-900/60 p-4 text-xs space-y-3">
            <p class="text-slate-300 font-medium">
                Snapshot Status Atlet
            </p>

            <div class="grid grid-cols-2 gap-3">
                <div class="rounded-xl bg-slate-950/60 border border-slate-800 p-3">
                    <p class="text-[11px] text-slate-400">Atlet Fit</p>
                    <p class="mt-1 text-xl font-semibold text-emerald-400">24</p>
                </div>
                <div class="rounded-xl bg-slate-950/60 border border-slate-800 p-3">
                    <p class="text-[11px] text-slate-400">Sedang Terapi</p>
                    <p class="mt-1 text-xl font-semibold text-amber-300">7</p>
                </div>
                <div class="rounded-xl bg-slate-950/60 border border-slate-800 p-3">
                    <p class="text-[11px] text-slate-400">Under Monitoring</p>
                    <p class="mt-1 text-xl font-semibold text-sky-300">5</p>
                </div>
                <div class="rounded-xl bg-slate-950/60 border border-slate-800 p-3">
                    <p class="text-[11px] text-slate-400">Restricted</p>
                    <p class="mt-1 text-xl font-semibold text-rose-300">3</p>
                </div>
            </div>

            <p class="text-[11px] text-slate-400">
                Data di atas masih dummy, tapi ngerepresentasikan integrasi modul atlet, screening, dan terapi di panel admin kamu.
            </p>
        </div>
    </div>
</section>
{{-- SECTION: Kenapa Garuda Fit Track? --}}
<section id="features" class="mt-10">
    <div class="space-y-2">
        <h2 class="text-lg font-semibold text-slate-50">
            Kenapa Garuda Fit Track?
        </h2>
        <p class="text-sm text-slate-400 max-w-xl">
            Sistem ini dibangun untuk ngejawab kebutuhan nyata pengelolaan atlet di lapangan:
            bukan cuma data profil, tapi juga kesehatan dan performa.
        </p>
    </div>

    <div class="mt-6 grid gap-4 md:grid-cols-3 text-sm">
        <x-section-card title="Satu sumber data">
    Data atlet, hasil screening, jadwal terapi, program latihan, dan prestasi 
    ada di satu sistem. Mengurangi file tercecer di Excel & chat.
</x-section-card>

<x-section-card title="Nyambung ke status medis">
    Status fit / restricted / under monitoring / active therapy 
    terhubung langsung ke riwayat screening dan terapi.
</x-section-card>

<x-section-card title="Siap dikembangkan">
    Dibangun dengan Laravel 12 + Filament sehingga mudah dikembangkan 
    ke portal atlet, pelatih, atau modul lain.
</x-section-card>
    </div>
</section>

{{-- SECTION: Modul Sistem (4 Grup) --}}
<section id="modules" class="mt-12 pb-4">
    <div class="space-y-2">
        <h2 class="text-lg font-semibold text-slate-50">
            Modul Utama Garuda Fit Track
        </h2>
        <p class="text-sm text-slate-400 max-w-xl">
            Sistem dibagi menjadi 4 modul besar agar mudah digunakan dan dipahami.
        </p>
    </div>

    <div class="mt-6 grid gap-4 md:grid-cols-2 lg:grid-cols-4 text-sm">

        <x-section-card title="Athlete Management">
            Mengelola data atlet, prestasi, dan program latihan dalam satu modul terintegrasi.
        </x-section-card>

        <x-section-card title="Health Management">
            Meliputi pemeriksaan kesehatan (screening) dan jadwal terapi yang terhubung langsung ke status atlet.
        </x-section-card>

        <x-section-card title="Expense Management">
            Mencatat pengeluaran tim seperti transportasi, peralatan, perawatan medis, dan operasional lainnya.
        </x-section-card>

        <x-section-card title="System & Supporting">
            Modul pendukung seperti manajemen user, pengaturan sistem, dan integrasi file atau log aktivitas.
        </x-section-card>

    </div>
</section>



@endsection
