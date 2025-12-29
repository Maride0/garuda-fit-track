<?php

namespace App\Filament\Resources\Achievements\Pages;

use App\Filament\Resources\Achievements\AchievementResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\Action;
use App\Filament\Resources\BaseEditRecord;

class EditAchievement extends BaseEditRecord
{
    protected static string $resource = AchievementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('backToIndex')
            ->label('Kembali ke Achievements')
            ->icon('heroicon-o-arrow-left')
            ->url(AchievementResource::getUrl())
            ->color('gray'),
            DeleteAction::make(),
        ];
    }
}
