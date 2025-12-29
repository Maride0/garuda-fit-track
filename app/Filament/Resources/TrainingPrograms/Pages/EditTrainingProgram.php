<?php

namespace App\Filament\Resources\TrainingPrograms\Pages;

use App\Filament\Resources\TrainingPrograms\TrainingProgramResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\BaseEditRecord;

class EditTrainingProgram extends BaseEditRecord
{
    protected static string $resource = TrainingProgramResource::class;

    public function getTitle(): string
    {
        $record = $this->getRecord();

        return 'Edit Program: ' . ($record->name ?? '');
    }

    public function getBreadcrumb(): string
    {
        return 'Detail Program';
    }
}