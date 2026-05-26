<?php

namespace App\Filament\Resources\Trips\Pages;

use App\Filament\Resources\Trips\TripResource;
use App\Filament\Resources\Trips\Widgets\TripStatsWidget;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTrips extends ListRecords
{
    protected static string $resource = TripResource::class;

    protected ?string $heading = 'Daftar Trip';

    protected ?string $subheading = 'Kelola semua perjalanan yang tersedia di platform TripKuy.';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Trip')
                ->icon('lucide-plus'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            TripStatsWidget::class,
        ];
    }
}
