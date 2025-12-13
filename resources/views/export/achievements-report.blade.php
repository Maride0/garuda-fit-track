<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Prestasi Atlet</title>

    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 6px; }
        th { background: #f5f5f5; }
    </style>
</head>
<body>

<!-- ========== HEADER START ========== -->
<div style="width: 100%; margin-bottom: 5px; font-family: DejaVu Sans, sans-serif;">

    <!-- Judul + Subjudul -->
    <div style="float: left; width: 70%;">
        <div style="font-size: 20px; font-weight: 600; margin:0;">
            Laporan Prestasi Atlet
        </div>

        <div style="font-size: 20px; font-weight: 600; margin-top:4px;">
            Periode: {{ date('d M Y', strtotime($from)) }}
            —
            {{ date('d M Y', strtotime($to)) }}
        </div>
    </div>

    <!-- Logo -->
    <div style="float: right; width: 30%; text-align: right;">
        <img src="{{ public_path('images/logo.jpg') }}"
             style="width:165px; height:auto;">
    </div>

    <div style="clear: both;"></div>
</div>

<!-- Garis 5 warna (Olimpik) -->
<div style="width: 100%; height: 10px; margin: 10px 0 20px 0;">
    <div style="width: 20%; height: 10px; float:left; background:#0085C7;"></div>
    <div style="width: 20%; height: 10px; float:left; background:#F4C300;"></div>
    <div style="width: 20%; height: 10px; float:left; background:#000000;"></div>
    <div style="width: 20%; height: 10px; float:left; background:#009F3D;"></div>
    <div style="width: 20%; height: 10px; float:left; background:#DF0024;"></div>
    <div style="clear: both;"></div>
</div>
<!-- ========== HEADER END ========== -->

<h3>Daftar Prestasi Atlet</h3>

<table>
    <thead>
        <tr>
            <th>Atlet</th>
            <th>Cabang</th>
            <th>Prestasi</th>
            <th>Event</th>
            <th>Tingkat</th>
            <th>Medali</th>
            <th>Peringkat</th>
            <th>Tanggal</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($data as $a)
        <tr>
            <td>{{ $a->athlete->name }}</td>
            <td>{{ $a->athlete->sport }}</td>
            <td>{{ $a->achievement_name }}</td>
            <td>{{ $a->event_name }}</td>
            <td>{{ ucfirst($a->competition_level) }}</td>
            <td>{{ ucfirst($a->medal_rank) }}</td>
            <td>{{ $a->rank ?? '-' }}</td>
            <td>{{ $a->start_date?->format('d M Y') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="8" style="text-align:center;">Tidak ada data untuk periode ini.</td>
        </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>
