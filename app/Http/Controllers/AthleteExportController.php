<?php

namespace App\Http\Controllers;

use App\Models\Athlete;
use Barryvdh\DomPDF\Facade\Pdf;

class AthleteExportController extends Controller
{
    public function export(string $athleteId)
    {
        $athlete = Athlete::with([
            'achievements',
            'healthScreenings',
            'performanceEvaluations',
            'testRecords.metric',
            'testRecords.trainingProgram',
        ])->findOrFail($athleteId);

        $pdf = Pdf::loadView('export.athlete-report', [
            'athlete' => $athlete,
        ])->setPaper('a4', 'portrait');

        return $pdf->download("Laporan_Atlet_{$athlete->name}.pdf");
    }
}
