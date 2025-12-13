<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pengeluaran</title>

    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 6px; }
        th { background: #f5f5f5; }
    </style>
</head>
<body>

<!-- ========== HEADER ========== -->
<div style="width: 100%; margin-bottom: 5px;">
    <div style="float:left; width:70%;">
        <div style="font-size:20px; font-weight:600;">
            Laporan Pengeluaran
        </div>

        <div style="font-size:18px; font-weight:600; margin-top:4px;">
            Periode:
            {{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }}
            {{ $year }}
        </div>
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

<h3>Daftar Pengeluaran</h3>

<table>
    <thead>
        <tr>
            <th>Kode</th>
            <th>Tanggal</th>
            <th>Nama Pencatat</th>
            <th>Kategori</th>
            <th>Deskripsi</th>
            <th>Jumlah</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
        @forelse($expenses as $e)
        <tr>
            <td>{{ $e->expenses_code }}</td>
            <td>{{ \Carbon\Carbon::parse($e->expense_date)->format('d M Y') }}</td>
            <td>{{ $e->applicant_name }}</td>
            <td>{{ ucwords($e->type) }}</td>
            <td>{{ $e->description }}</td>
            <td>Rp {{ number_format($e->amount, 0, ',', '.') }}</td>
            <td>{{ ucfirst($e->status) }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="7" style="text-align:center;">
                Tidak ada data pengeluaran pada periode ini.
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>
