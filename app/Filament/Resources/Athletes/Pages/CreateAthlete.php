<?php

namespace App\Filament\Resources\Athletes\Pages;

use App\Filament\Resources\Athletes\AthleteResource;
use App\Models\Athlete;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\BaseCreateRecord;

class CreateAthlete extends BaseCreateRecord
{
    protected static string $resource = AthleteResource::class;

    public ?string $generatedId = null;

    public function mount(): void
    {
        parent::mount();

        $lastId = Athlete::query()
            ->where('athlete_id', 'like', 'ATH%')
            ->orderBy('athlete_id', 'desc')
            ->value('athlete_id');

        $num = $lastId
            ? ((int) substr($lastId, 3)) + 1
            : 1;

        $this->generatedId = 'ATH' . str_pad((string) $num, 4, '0', STR_PAD_LEFT);

        // ✅ jangan fill athlete_id ke form biar gak tampil di UI
        // $this->form->fill([
        //     'athlete_id' => $this->generatedId,
        // ]);
    } // ✅ INI WAJIB ADA (penutup mount)

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['athlete_id'] = $this->generatedId;

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

        public static function getNavigationLabel(): string
    {
        return 'Atlet';
    }

    public function getTitle(): string
    {
        return 'Tambah Atlet';
    }

    public function getBreadcrumb(): string
    {
        return 'Tambah';
    }
}
