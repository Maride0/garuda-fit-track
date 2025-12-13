<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Atlet</title>

    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 6px; }
        th { background: #f5f5f5; }
    </style>
</head>
<body>

<!-- ========== HEADER START ========== -->
<!-- HEADER TANPA TABLE -->
<div style="width: 100%; margin-bottom: 5px; font-family: DejaVu Sans, sans-serif;">

    <!-- Kiri: Judul + Nama Atlet -->
    <div style="float: left; width: 70%;">
        <div style="font-size: 20px; font-weight: 600; margin:0;">
            Laporan Atlet
        </div>

        <div style="font-size: 20px; font-weight: 600; margin-top:4px;">
            {{ $athlete->name }}
        </div>
    </div>

    <!-- Kanan: Logo -->
    <div style="float: right; width: 30%; text-align: right;">
        <img src="{{ public_path('images/logo.jpg') }}"
             style="width:165px; height:auto;">
    </div>

    <div style="clear: both;"></div>
</div>

<div style="width: 100%; height: 10px; margin: 10px 0 20px 0;">
    <div style="width: 20%; height: 10px; float:left; background:#0085C7;"></div> <!-- Blue -->
    <div style="width: 20%; height: 10px; float:left; background:#F4C300;"></div> <!-- Yellow -->
    <div style="width: 20%; height: 10px; float:left; background:#000000;"></div> <!-- Black -->
    <div style="width: 20%; height: 10px; float:left; background:#009F3D;"></div> <!-- Green -->
    <div style="width: 20%; height: 10px; float:left; background:#DF0024;"></div> <!-- Red -->
    <div style="clear: both;"></div>
</div>


<p><strong>ID:</strong> {{ $athlete->athlete_id }}</p>
<p><strong>Cabang:</strong> {{ $athlete->sport }} ({{ ucfirst($athlete->sport_category) }})</p>
<p><strong>Umur:</strong> {{ $athlete->age }} tahun</p>
<p><strong>Status:</strong> {{ ucfirst($athlete->status) }}</p>
<p><strong>Next Screening:</strong> {{ $athlete->next_screening_due?->format('d M Y') ?? '-' }}</p>

<hr>

<h3>Prestasi</h3>
@if($athlete->achievements->isEmpty())
<p>Tidak ada data.</p>
@else
<table>
    <thead>
        <tr>
            <th>Event</th>
            <th>Tingkat</th>
            <th>Prestasi</th>
            <th>Medal</th>
            <th>Peringkat</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($athlete->achievements as $a)
        <tr>
            <td>{{ $a->event_name }}</td>
            <td>{{ ucfirst($a->competition_level) }}</td>
            <td>{{ $a->achievement_name }}</td>
            <td>{{ ucfirst($a->medal_rank) }}</td>
            <td>{{ $a->rank ?? '-' }}</td>
            <td>{{ $a->start_date?->format('d M Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

<hr>

<h3>Riwayat Screening</h3>
@if($athlete->healthScreenings->isEmpty())
<p>Tidak ada data.</p>
@else
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Jenis</th>
            <th>Hasil</th>
            <th>Catatan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($athlete->healthScreenings as $s)
        <tr>
            <td>{{ $s->screening_id }}</td>
            <td>{{ $s->screening_date?->format('d M Y') }}</td>
            <td>{{ ucfirst($s->exam_type) }}</td>
            <td>{{ ucfirst($s->display_result) }}</td>
            <td>{{ $s->notes }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

<hr>

<h3>Program Evaluations</h3>
@if($athlete->performanceEvaluations->isEmpty())
<p>Tidak ada data.</p>
@else
<table>
    <thead>
        <tr>
            <th>Program</th>
            <th>Tanggal</th>
            <th>Rating</th>
            <th>Disc.</th>
            <th>Effort</th>
            <th>Att.</th>
            <th>Tactical</th>
        </tr>
    </thead>
    <tbody>
        @foreach($athlete->performanceEvaluations as $p)
        <tr>
            <td>{{ $p->program->name ?? '-' }}</td>
            <td>{{ $p->evaluation_date?->format('d M Y') }}</td>
            <td>{{ $p->overall_rating }}</td>
            <td>{{ $p->discipline_score }}</td>
            <td>{{ $p->effort_score }}</td>
            <td>{{ $p->attitude_score }}</td>
            <td>{{ $p->tactical_understanding_score }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

<hr>

<h3>Test Records</h3>
@if($athlete->testRecords->isEmpty())
<p>Tidak ada data.</p>
@else
<table>
    <thead>
        <tr>
            <th>Metric</th>
            <th>Program</th>
            <th>Tanggal</th>
            <th>Phase</th>
            <th>Value</th>
            <th>Source</th>
        </tr>
    </thead>
    <tbody>
        @foreach($athlete->testRecords as $t)
        <tr>
            <td>{{ $t->metric->name }}</td>
            <td>{{ $t->trainingProgram->name ?? '—' }}</td>
            <td>{{ $t->test_date?->format('d M Y') }}</td>
            <td>{{ ucfirst($t->phase) }}</td>
            <td>{{ $t->value }} {{ $t->unit ?? $t->metric->default_unit }}</td>
            <td>{{ $t->source }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

</body>
</html>
