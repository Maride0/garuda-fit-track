<?php

namespace App\Filament\Resources\Achievements\Pages;

use App\Filament\Resources\Achievements\AchievementResource;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\BaseCreateRecord;

class CreateAchievement extends BaseCreateRecord
{
    protected static string $resource = AchievementResource::class;

        public static function getNavigationLabel(): string
    {
        return 'Prestasi';
    }

    public function getTitle(): string
    {
        return 'Tambah Prestasi';
    }

    public function getBreadcrumb(): string
    {
        return 'Tambah';
    }
    
}
