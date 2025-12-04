<?php

namespace App\Filament\Resources\TherapySchedules\Pages;

use App\Filament\Resources\TherapySchedules\TherapyScheduleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\Action;

class EditTherapySchedule extends EditRecord
{
    protected static string $resource = TherapyScheduleResource::class;

    // 🔹 Ganti title biar nggak ada kata "Edit"
    public function getTitle(): string
    {
        $athleteName = $this->record?->athlete?->name;
        $screeningId = $this->record?->healthScreening?->screening_id;

        $parts = array_filter([
            'Therapy Schedule',
            $athleteName,
            $screeningId,
        ]);

        return implode(' • ', $parts) ?: 'Therapy Schedule';
    }
    // (opsional) ganti breadcrumb terakhir juga biar nggak tulis "Edit"
    public function getBreadcrumb(): string
    {
        $screeningId = $this->record?->healthScreening?->screening_id;

        if ($screeningId) {
            return "TS {$screeningId}";
        }

        // fallback kalau belum ada relasi / screening_id
        return 'TS ' . ($this->record?->id ?? '');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('backToIndex')
                ->label('Kembali ke Therapy Schedules')
                ->icon('heroicon-o-arrow-left')
                ->url(TherapyScheduleResource::getUrl())
                ->color('gray'),
            DeleteAction::make(),
        ];
    }
    
}
