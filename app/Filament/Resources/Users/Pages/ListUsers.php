<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Filament\Resources\Users\Widgets\UserStatsWidget;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected ?string $heading = 'Daftar Pengguna';

    protected ?string $subheading = 'Kelola akun pengguna dan hak akses admin.';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Pengguna')
                ->icon('lucide-user-plus'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            UserStatsWidget::class,
        ];
    }
}
