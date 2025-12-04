<?php

namespace App\Filament\Resources\HealthScreenings\Pages;

use App\Models\TherapySchedule;
use App\Filament\Resources\HealthScreenings\HealthScreeningResource;
use App\Filament\Resources\TherapySchedules\TherapyScheduleResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHealthScreening extends EditRecord
{
    protected static string $resource = HealthScreeningResource::class;

    // 🔹 Custom title (hapus "Edit")
    public function getTitle(): string
    {
        $athleteName = $this->record?->athlete?->name;
        $date = $this->record?->screening_date
            ? $this->record->screening_date->translatedFormat('d M Y')
            : null;

        $parts = array_filter([
            'Health Screening',
            $athleteName,
            $date,
        ]);

        return implode(' • ', $parts) ?: 'Health Screening';
    }

    // 🔹 Custom breadcrumb terakhir
    public function getBreadcrumb(): string
    {
        return 'Detail Health Screening';
    }

    /**
     * Helper: tentukan therapy schedule mana yang harus di-link
     * - Kalau screening ini punya therapySchedule sendiri → pakai itu
     * - Kalau ini follow_up dan atlet punya therapy aktif → pakai therapy aktif terbaru
     */
    protected function getLinkedTherapySchedule(): ?TherapySchedule
    {
        $screening = $this->record;

        if (! $screening) {
            return null;
        }

        // 1) Kalau screening ini sendiri sudah punya therapy schedule, langsung pakai itu
        if ($screening->therapySchedule) {
            return $screening->therapySchedule;
        }

        // 2) Kalau ini follow-up → pakai previous therapy si atlet (yang belum final)
        if ($screening->exam_type === 'follow_up' && $screening->athlete) {
            return $screening->athlete
                ->therapySchedules()
                ->notFinal()                 // status != completed/cancelled
                ->latest('updated_at')
                ->latest('id')
                ->first();
        }

        // 3) selain itu: gak ada therapy yang relevan
        return null;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('backToIndex')
            ->label('Kembali ke Health Screenings')
            ->icon('heroicon-o-arrow-left')
            ->url(HealthScreeningResource::getUrl())
            ->color('gray'),

            Action::make('therapySchedule')
                ->label(function () {
                    $linked = $this->getLinkedTherapySchedule();

                    return $linked
                        ? 'Edit Therapy Schedule'
                        : 'Set Therapy Schedule';
                })
                ->icon('heroicon-o-calendar-days')
                ->visible(function () {
                    // Hasil screening harus terkait terapi dulu
                    if (! in_array($this->record->screening_result, ['requires_therapy', 'active_therapy'], true)) {
                        return false;
                    }

                    $linked = $this->getLinkedTherapySchedule();

                    // ✅ MODE EDIT: hanya muncul kalau sudah di-finalize
                    if ($linked) {
                        return $this->record->is_locked === true;
                    }

                    // ✅ MODE SET: boleh muncul walau belum di-finalize
                    return true;
                })
                ->url(function () {
                    $linked = $this->getLinkedTherapySchedule();

                    if ($linked) {
                        // 🔹 EDIT / DETAIL (termasuk flow follow-up ke previous therapy)
                        return TherapyScheduleResource::getUrl('edit', [
                            'record' => $linked->getKey(),
                        ]);
                    }

                    // 🔹 SET pertama kali (screening awal, belum punya therapy)
                    return TherapyScheduleResource::getUrl('create', [
                        'athlete_id'          => $this->record->athlete_id,
                        'health_screening_id' => $this->record->screening_id,
                    ]);
                }),

                Action::make('finalize')
                    ->label('Finalize Screening')
                    ->icon('heroicon-o-lock-closed')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->visible(fn () => ! $this->record->is_locked)
                    ->action(function () {
                        $screening = $this->record;
                        $data      = $this->form->getState();

                        // Kalau BUKAN follow_up dan sudah ada therapySchedule yang di-generate dari screening ini,
                        // update jadwal terapi pakai field di form
                        if ($screening->exam_type !== 'follow_up' && $screening->therapySchedule) {
                            $schedule = $screening->therapySchedule;

                            $schedule->update([
                                'therapy_type'   => $data['therapy_type_form']       ?? $schedule->therapy_type,
                                'therapist_name' => $data['therapist_name_form']     ?? $schedule->therapist_name,
                                'start_date'     => $data['therapy_start_date_form'] ?? $schedule->start_date,
                                'end_date'       => $data['therapy_end_date_form']   ?? $schedule->end_date,
                                'frequency'      => $data['therapy_frequency_form']  ?? $schedule->frequency,
                            ]);
                        }

                        $screening->is_locked    = true;
                        $screening->finalized_at = now();
                        $screening->save();
                    }),

                DeleteAction::make()
                    ->visible(fn () => ! $this->record->is_locked),
            ];
    }

    // ❌ Hilangkan tombol Save/Cancel bawaan form
    protected function getFormActions(): array
    {
        return [];
    }
}