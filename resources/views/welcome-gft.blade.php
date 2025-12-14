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
                <x-button href="/admin/login" variant="primary">
                    Buka Panel Admin
                </x-button>
                <x-button href="/supervisor/login" variant="primary">
                    Buka Panel Supervisor
                </x-button>
                <x-button href="#modules" variant="outline">
                    Lihat Modul Sistem
                </x-button>
            </div>

        </div>

        {{-- Kanan: kartu overview (REAL) --}}
        @php
            // Fallback aman kalau controller belum ngirim variabel
            $snapshot = $snapshot ?? [
                'not_screened'     => 0,
                'fit'              => 0,
                'under_monitoring' => 0,
                'active_therapy'   => 0,
                'restricted'       => 0,
            ];

            $totalAthletes = $totalAthletes ?? array_sum($snapshot);
        @endphp

        <div class="rounded-2xl border border-slate-800 bg-slate-900/60 p-4 text-xs space-y-3">
            <div class="flex items-start justify-between gap-3">
                <p class="text-slate-300 font-medium">
                    Snapshot Status Atlet
                </p>

                <span class="shrink-0 rounded-full border border-emerald-500/40 bg-emerald-500/10 px-2 py-0.5 text-[10px] text-emerald-300">
                    LIVE
                </span>
            </div>

            <p class="text-[11px] text-slate-400">
                Total atlet terdaftar: <span class="text-slate-200 font-medium">{{ $totalAthletes }}</span>
            </p>

            <div class="grid grid-cols-2 gap-3">
                <div class="rounded-xl bg-slate-950/60 border border-slate-800 p-3">
                    <p class="text-[11px] text-slate-400">Atlet Fit</p>
                    <p class="mt-1 text-xl font-semibold text-emerald-400">
                        {{ (int) ($snapshot['fit'] ?? 0) }}
                    </p>
                </div>

                <div class="rounded-xl bg-slate-950/60 border border-slate-800 p-3">
                    <p class="text-[11px] text-slate-400">Sedang Terapi</p>
                    <p class="mt-1 text-xl font-semibold text-amber-300">
                        {{ (int) ($snapshot['active_therapy'] ?? 0) }}
                    </p>
                </div>

                <div class="rounded-xl bg-slate-950/60 border border-slate-800 p-3">
                    <p class="text-[11px] text-slate-400">Under Monitoring</p>
                    <p class="mt-1 text-xl font-semibold text-sky-300">
                        {{ (int) ($snapshot['under_monitoring'] ?? 0) }}
                    </p>
                </div>

                <div class="rounded-xl bg-slate-950/60 border border-slate-800 p-3">
                    <p class="text-[11px] text-slate-400">Restricted</p>
                    <p class="mt-1 text-xl font-semibold text-rose-300">
                        {{ (int) ($snapshot['restricted'] ?? 0) }}
                    </p>
                </div>
            </div>
            <p class="text-[11px] text-slate-400">
                Ringkasan ini otomatis ngambil dari status atlet di database (hasil integrasi modul atlet, screening, dan terapi).
            </p>
    </div>
</section>
{{-- SECTION: Kenapa Garuda Fit Track? --}}
<section id="features" class="mt-10">
    <div class="space-y-2">
        <h2 class="text-lg font-semibold text-slate-50">
            Kenapa Garuda Fit Track?
        </h2>
        <p class="text-sm text-slate-400 max-w-xl">
            Garuda Fit Track dikembangkan sebagai sistem pendukung pengelolaan atlet
            yang berfokus pada pencatatan dan pengorganisasian data secara terstruktur.
        </p>
    </div>

    <div class="mt-6 grid gap-4 md:grid-cols-3 text-sm">
        <x-section-card title="Satu sumber data terpusat">
            Sistem mengelola data atlet, prestasi, program latihan,
            parameter kinerja, catatan tes performa, serta data kesehatan
            dalam satu platform yang terintegrasi.
        </x-section-card>

        <x-section-card title="Struktur modul yang jelas">
            Fitur dalam sistem dibagi ke dalam modul yang terpisah,
            seperti manajemen atlet, pengembangan atlet, kesehatan,
            dan keuangan, sehingga alur penggunaan lebih mudah dipahami.
        </x-section-card>

        <x-section-card title="Mendukung proses pembinaan atlet">
            Dengan pencatatan data yang rapi dan konsisten,
            sistem membantu pihak terkait dalam memantau
            aktivitas pembinaan atlet secara administratif.
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
            Sistem dibagi menjadi empat modul utama untuk mendukung pengelolaan atlet secara menyeluruh,
            mulai dari data dasar, pengembangan performa, kesehatan, hingga keuangan.
        </p>
    </div>

    <div class="mt-6 grid gap-4 md:grid-cols-2 lg:grid-cols-4 text-sm">

        <x-section-card title="Manajemen Atlet">
            Mengelola data atlet dan pencapaian prestasi sebagai dasar utama
            dalam pemantauan dan pengambilan keputusan.
        </x-section-card>

        <x-section-card title="Pengembangan Atlet">
            Mengelola program latihan, parameter kinerja atlet,
            serta pencatatan hasil tes performa untuk memantau perkembangan atlet.
        </x-section-card>

        <x-section-card title="Manajemen Kesehatan">
            Mencakup pemeriksaan kesehatan (health screening) dan jadwal terapi
            yang terhubung langsung dengan status kondisi atlet.
        </x-section-card>

        <x-section-card title="Finance">
            Mencatat dan memantau pengeluaran terkait kebutuhan atlet,
            seperti peralatan, perawatan medis, dan operasional pendukung lainnya.
        </x-section-card>

    </div>
</section>




@endsection
