<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Evaluasi Program</title>

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

    <div style="float: left; width: 70%;">
        <div style="font-size: 20px; font-weight: 600;">
            Laporan Evaluasi Program
        </div>

        <div style="font-size: 18px; font-weight: 600; margin-top:4px;">
            {{ $program->name }} :{{ date('d M Y', strtotime($from)) }}
            —
            {{ date('d M Y', strtotime($to)) }}
        </div>
    </div>

    <div style="float: right; width: 30%; text-align: right;">
        <img src="{{ public_path('images/logo.jpg') }}" style="width:160px;">
    </div>

    <div style="clear: both;"></div>
</div>

<!-- GARIS 5 WARNA -->
<div style="width: 100%; height: 10px; margin: 10px 0 20px 0;">
    <div style="width: 20%; height: 10px; float:left; background:#0085C7;"></div>
    <div style="width: 20%; height: 10px; float:left; background:#F4C300;"></div>
    <div style="width: 20%; height: 10px; float:left; background:#000000;"></div>
    <div style="width: 20%; height: 10px; float:left; background:#009F3D;"></div>
    <div style="width: 20%; height: 10px; float:left; background:#DF0024;"></div>
    <div style="clear: both;"></div>
</div>

<h3>Daftar Evaluasi Atlet</h3>

<table>
    <thead>
        <tr>
            <th>Atlet</th>
            <th>Tanggal</th>
            <th>Rating</th>
            <th>Metric</th>
            <th>Value</th>
            <th>Notes</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($evaluations as $e)
        <tr>
            <td>{{ $e->athlete->name }}</td>
            <td>{{ $e->evaluation_date?->format('d/m/Y') }}</td>
            <td>{{ $e->overall_rating }}</td>
            <td>{{ $e->metric->name ?? '-' }}</td>

            <td>
                @if ($e->value_numeric)
                    {{ $e->value_numeric }}
                @else
                    {{ $e->value_label ?? '-' }}
                @endif
            </td>

            <td>{{ $e->coach_notes ?? '-' }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="6" style="text-align:center;">
                Tidak ada data untuk periode ini.
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>
