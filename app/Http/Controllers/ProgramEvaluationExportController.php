<?php

namespace App\Http\Controllers;

use App\Models\PerformanceEvaluation;
use App\Models\TrainingProgram;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ProgramEvaluationExportController extends Controller
{
    public function export(Request $request, $programId)
    {
        $request->validate([
            'from' => 'required|date',
            'to'   => 'required|date',
        ]);

        $program = TrainingProgram::with('athletes')->findOrFail($programId);

        $evaluations = PerformanceEvaluation::with(['athlete', 'metric'])
            ->where('training_program_id', $programId)
            ->whereBetween('evaluation_date', [$request->from, $request->to])
            ->orderBy('evaluation_date')
            ->get();

        $pdf = Pdf::loadView('export.program-evaluation-report', [
            'program'     => $program,
            'evaluations' => $evaluations,
            'from'        => $request->from,
            'to'          => $request->to,
        ])->setPaper('A4', 'portrait');

        return $pdf->download("Laporan_Evaluasi_Program_{$request->from}_sampai_{$request->to}.pdf");
    }
}
