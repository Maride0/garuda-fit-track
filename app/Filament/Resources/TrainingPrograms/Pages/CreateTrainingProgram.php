<?php

namespace App\Filament\Resources\TrainingPrograms\Pages;

use App\Filament\Resources\TrainingPrograms\TrainingProgramResource;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\BaseCreateRecord;

class CreateTrainingProgram extends BaseCreateRecord
{
    protected static string $resource = TrainingProgramResource::class;

    public function getTitle(): string
    {
        return 'Tambah Program Latihan';
    }

    public function getBreadcrumb(): string
    {
        return 'Tambah';
    }
}
