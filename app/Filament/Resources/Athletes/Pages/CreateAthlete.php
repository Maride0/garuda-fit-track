<?php

namespace App\Filament\Resources\Athletes\Pages;

use App\Filament\Resources\Athletes\AthleteResource;
use App\Models\Athlete;
use Filament\Resources\Pages\CreateRecord;

class CreateAthlete extends CreateRecord
{
    protected static string $resource = AthleteResource::class;

    public ?string $generatedId = null;

    public function mount(): void
    {
        parent::mount();

        // Ambil athlete_id terakhir yang formatnya ATH####
        $lastId = Athlete::query()
            ->where('athlete_id', 'like', 'ATH%')
            ->orderBy('athlete_id', 'desc')
            ->value('athlete_id');

        // Hitung angka berikutnya
        if ($lastId) {
            // contoh: ATH0023 → ambil "0023", naikkan jadi 24
            $num = (int) substr($lastId, 3) + 1;
        } else {
            $num = 1; // kalau belum ada atlet sama sekali
        }

        // Bentuk ATH0001, ATH0002, ATH0003 ...
        $this->generatedId = 'ATH' . str_pad((string) $num, 4, '0', STR_PAD_LEFT);

        // Pre-fill form state → langsung muncul di form
        $this->form->fill([
            'athlete_id' => $this->generatedId,
        ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Pastikan yang disimpan selalu ID yang kita generate
        $data['athlete_id'] = $this->generatedId;

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        // Setelah create, balik ke list/table Athletes
        return $this->getResource()::getUrl('index');
    }
}
