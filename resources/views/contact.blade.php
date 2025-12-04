@extends('layouts.app')

@section('content')

<section class="space-y-4 max-w-xl">
    <h1 class="text-2xl font-semibold">Kontak & Dukungan</h1>

    <p class="text-sm text-slate-300 leading-relaxed">
        Jika kamu ingin mengembangkan Garuda Fit Track lebih jauh, menambah modul baru,
        atau mengintegrasikan dengan sistem lain, halaman ini bisa jadi titik awal informasi kontak.
    </p>

    {{-- Info kontak statis --}}
    <div class="rounded-2xl border border-slate-800 bg-slate-900/60 p-4 text-sm space-y-1">
        <p class="text-slate-200 font-medium">Informasi Kontak</p>
        <p class="text-slate-300 text-[13px]">
            Email pengembang: <span class="text-emerald-300">support@gft.local</span> (dummy, bisa kamu ganti nanti)
        </p>
        <p class="text-slate-400 text-[12px]">
            Catatan: alamat email ini hanya placeholder untuk keperluan tampilan.
        </p>
    </div>

    {{-- Form dummy (frontend only) --}}
    <div class="rounded-2xl border border-slate-800 bg-slate-900/60 p-4">
        <p class="text-sm font-medium text-slate-100 mb-3">
            Kirim pesan (dummy form)
        </p>

        <form class="space-y-3 text-sm">
            <div class="space-y-1">
                <label for="name" class="text-slate-200">Nama</label>
                <input id="name" type="text"
                       class="w-full rounded-xl border border-slate-700 bg-slate-950/60 px-3 py-2 text-sm text-slate-100 focus:outline-none focus:ring-1 focus:ring-emerald-400">
            </div>

            <div class="space-y-1">
                <label for="email" class="text-slate-200">Email</label>
                <input id="email" type="email"
                       class="w-full rounded-xl border border-slate-700 bg-slate-950/60 px-3 py-2 text-sm text-slate-100 focus:outline-none focus:ring-1 focus:ring-emerald-400">
            </div>

            <div class="space-y-1">
                <label for="message" class="text-slate-200">Pesan</label>
                <textarea id="message" rows="4"
                          class="w-full rounded-xl border border-slate-700 bg-slate-950/60 px-3 py-2 text-sm text-slate-100 focus:outline-none focus:ring-1 focus:ring-emerald-400"></textarea>
            </div>

            <x-button type="button" size="sm" class="mt-1">
                (Dummy) Kirim Pesan
            </x-button>

            <p class="text-[11px] text-slate-500 mt-2">
                Tombol ini belum terhubung ke backend. Ini cuma contoh tampilan form di frontend.
            </p>
        </form>
    </div>
</section>

@endsection
