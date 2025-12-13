<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Skrining Kesehatan</title>

    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 6px; }
        th { background: #f5f5f5; }
    </style>
</head>
<body>

<!-- HEADER -->
<div style="width: 100%; margin-bottom: 5px;">
    <div style="float:left; width:70%;">
        <div style="font-size:20px; font-weight:600;">
            Laporan Skrining Kesehatan
        </div>

        <div style="font-size:18px; font-weight:600; margin-top:4px;">
            Periode:
            {{ \Carbon\Carbon::parse($from)->format('d M Y') }}
            —
            {{ \Carbon\Carbon::parse($to)->format('d M Y') }}
        </div>

        @if(!empty($result))
        <div style="font-size:14px; margin-top:3px;">
            Hasil:
            <strong>
                {{ str_replace('_', ' ', ucfirst($result)) }}
            </strong>
        </div>
        @endif
    </div>

    <div style="float:right; width:30%; text-align:right;">
        <img src="{{ public_path('images/logo.jpg') }}" style="width:160px;">
    </div>

    <div style="clear:both;"></div>
</div>

<!-- GARIS 5 WARNA -->
<div style="width: 100%; height: 10px; margin: 10px 0 20px 0;">
    <div style="width:20%; height:10px; float:left; background:#0085C7;"></div>
    <div style="width:20%; height:10px; float:left; background:#F4C300;"></div>
    <div style="width:20%; height:10px; float:left; background:#000000;"></div>
    <div style="width:20%; height:10px; float:left; background:#009F3D;"></div>
    <div style="width:20%; height:10px; float:left; background:#DF0024;"></div>
    <div style="clear: both;"></div>
</div>

<h3>Daftar Skrining</h3>

<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Atlet</th>
            <th>Jenis</th>
            <th>Hasil</th>
            <th>Catatan</th>
        </tr>
    </thead>

    <tbody>
        @forelse($data as $s)
        <tr>
            <td>{{ $s->screening_date?->format('d M Y') }}</td>
            <td>{{ $s->athlete->name }}</td>
            <td>{{ ucfirst(str_replace('_', ' ', $s->exam_type)) }}</td>
            <td>{{ ucfirst(str_replace('_', ' ', $s->display_result)) }}</td>
            <td>{{ $s->notes ?? '-' }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="5" style="text-align:center;">
                Tidak ada data untuk periode ini.
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>
