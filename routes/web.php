<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AthleteExportController;
use App\Http\Controllers\AchievementExportController;
use App\Http\Controllers\ProgramEvaluationExportController;
use App\Http\Controllers\HealthScreeningExportController;
use App\Http\Controllers\LandingController; // <<< INI WAJIB

Route::get('/athletes/{athlete_id}/export-pdf', [AthleteExportController::class, 'export'])
    ->name('athletes.export.pdf');

Route::get('/achievements/export/pdf', [AchievementExportController::class, 'export'])
    ->name('achievements.export.pdf');

Route::get('/program-evaluations/{program}/export', [ProgramEvaluationExportController::class, 'export'])
    ->name('program-evaluations.export');

Route::get('/health/export/pdf', [HealthScreeningExportController::class, 'export'])
    ->name('health.export.pdf');

// ✅ Beranda cuma SATU
Route::get('/', LandingController::class)->name('landing');

Route::view('/about', 'about');
Route::view('/contact', 'contact');
