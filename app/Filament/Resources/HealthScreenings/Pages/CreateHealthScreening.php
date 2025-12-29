<?php

namespace App\Filament\Resources\HealthScreenings\Pages;

use App\Filament\Resources\HealthScreenings\HealthScreeningResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\TherapySchedule;
use App\Models\HealthScreening;
use App\Filament\Resources\BaseCreateRecord;

class CreateHealthScreening extends BaseCreateRecord
{
    protected static string $resource = HealthScreeningResource::class;

    /**
     * Sebelum data disimpan, generate:
     * - auto_increment (counter)
     * - screening_id (SCR0001, SCR0002, dst.)
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // cari nilai auto_increment terbesar sekarang
        $nextNumber = (HealthScreening::max('auto_increment') ?? 0) + 1;

        $data['auto_increment'] = $nextNumber;
        $data['screening_id']   = 'SCR' . str_pad((string) $nextNumber, 4, '0', STR_PAD_LEFT);

        return $data;
    }

    protected function afterCreate(): void
    {
        $data      = $this->form->getState();
        $screening = $this->record;
        $athlete   = $screening->athlete;

        /*
        |--------------------------------------------------------------------------
        | 1. FOLLOW-UP
        |--------------------------------------------------------------------------
        | Tidak membuat TherapySchedule baru.
        | Kalau hasil follow up = FIT → terapi di-set completed + end_date auto.
        */
        if (($data['exam_type'] ?? null) === 'follow_up') {

        $scheduleId = $data['follow_up_therapy_schedule_id']
            ?? $screening->follow_up_therapy_schedule_id;

        $schedule = $scheduleId
            ? TherapySchedule::find($scheduleId)
            : null;

        if ($schedule) {
            // 1) Kalau hasil follow-up = FIT → terapi selesai
            if ($screening->screening_result === 'fit') {
                $completionDate = $screening->screening_date
                    ? $screening->screening_date->toDateString()
                    : now()->toDateString();

                $schedule->update([
                    'status'   => 'completed',
                    'end_date' => $completionDate,
                ]);
            }

            // 2) 🔸 BARU: kalau hasil masih "requires_therapy"
            //    dan jadwalnya masih active/planned → anggap terapi aktif
            if (
                $screening->screening_result === 'requires_therapy'
                && in_array($schedule->status, ['active', 'planned'])
            ) {
                $screening->update([
                    'screening_result' => 'active_therapy',
                ]);
            }
        }

        // refresh supaya match() pakai nilai screening_result terbaru
        $screening->refresh();

        // Update status atlet sesuai hasil follow-up (pakai nilai yg sudah bisa jadi diubah)
        $athleteStatus = match ($screening->screening_result) {
            'fit'              => 'fit',
            'restricted'       => 'restricted',
            'requires_therapy' => 'under_monitoring',
            'active_therapy'   => 'active_therapy',
            default            => $athlete->status,
        };

        $athlete->update([
            'status' => $athleteStatus,
        ]);

        return;
    }
        /*
        |--------------------------------------------------------------------------
        | 2. NON-FOLLOW-UP (initial / injury / competition)
        |--------------------------------------------------------------------------
        */

        // Update status atlet berdasarkan hasil screening awal
        $athleteStatus = match ($screening->screening_result) {
            'fit'              => 'fit',
            'restricted'       => 'restricted',
            'requires_therapy' => 'under_monitoring',
            'active_therapy'   => 'active_therapy',
            default            => $athlete->status,
        };

        $athlete->update([
            'status' => $athleteStatus,
        ]);

        // Kalau hasilnya bukan requires_therapy → tidak buat therapy schedule
        if (($data['screening_result'] ?? null) !== 'requires_therapy') {
            return;
        }

        // Minimal validasi basic: type & start_date harus ada
        if (empty($data['therapy_type_form']) || empty($data['therapy_start_date_form'])) {
            return;
        }

        // ⬇️ INI PERSIS LOGIKA AWALMU, HANYA GANTI id → screening_id
        TherapySchedule::create([
            'athlete_id'          => $screening->athlete_id,
            'health_screening_id' => $screening->screening_id, // DULUNYA $screening->id

            'therapy_type'        => $data['therapy_type_form'] ?? null,
            'therapist_name'      => $data['therapist_name_form'] ?? null,
            'start_date'          => $data['therapy_start_date_form'] ?? null,
            'end_date'            => $data['therapy_end_date_form'] ?? null,
            'frequency'           => $data['therapy_frequency_form'] ?? null,
            'status'              => 'planned',
            'progress'            => 0,
            'notes'               => $data['notes'] ?? null,
        ]);

        // Setelah jadwal dibuat: set screening_result + status atlet ke active_therapy
        $screening->update([
            'screening_result' => 'active_therapy',
        ]);

        $athlete->update([
            'status' => 'active_therapy',
        ]);
    }

        public static function getNavigationLabel(): string
    {
        return 'Skrining Kesehatan';
    }

    public function getTitle(): string
    {
        return 'Tambah Skrining';
    }

    public function getBreadcrumb(): string
    {
        return 'Tambah';
    }
}
