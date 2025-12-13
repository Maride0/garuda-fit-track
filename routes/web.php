<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AthleteExportController;
use App\Http\Controllers\AchievementExportController;
use App\Http\Controllers\ProgramEvaluationExportController;
use App\Http\Controllers\HealthScreeningExportController;

Route::get('/athletes/{athlete_id}/export-pdf', [AthleteExportController::class, 'export'])
    ->name('athletes.export.pdf');

Route::get('/achievements/export/pdf', [AchievementExportController::class, 'export'])
    ->name('achievements.export.pdf');

Route::get('/program-evaluations/{program}/export', [ProgramEvaluationExportController::class, 'export'])
    ->name('program-evaluations.export');

Route::get('/health/export/pdf', [HealthScreeningExportController::class, 'export'])
    ->name('health.export.pdf');

Route::get('/', function () {
    return view('welcome-gft');
});
Route::get('/about', function () {
    return view('about');
});
Route::get('/contact', function () {
    return view('contact');
});


