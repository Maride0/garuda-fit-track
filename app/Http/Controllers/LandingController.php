<?php

namespace App\Http\Controllers;

use App\Models\Athlete;

class LandingController
{
    public function __invoke()
    {
        $stats = Athlete::query()
            ->selectRaw("status, COUNT(*) as total")
            ->groupBy("status")
            ->pluck("total", "status")
            ->toArray();

        $snapshot = [
            'not_screened'     => (int) ($stats['not_screened'] ?? 0),
            'fit'              => (int) ($stats['fit'] ?? 0),
            'under_monitoring' => (int) ($stats['under_monitoring'] ?? 0),
            'active_therapy'   => (int) ($stats['active_therapy'] ?? 0),
            'restricted'       => (int) ($stats['restricted'] ?? 0),
        ];

        return view('welcome-gft', [
            'title'         => 'Garuda Fit Track',
            'snapshot'      => $snapshot,
            'totalAthletes' => Athlete::count(),
        ]);
    }
}
