<?php

namespace App\Filament\Resources\Reviews\Pages;

use App\Filament\Resources\Reviews\ReviewResource;
use App\Filament\Resources\Reviews\Widgets\ReviewStatsWidget;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageReviews extends ManageRecords
{
    protected static string $resource = ReviewResource::class;

    protected ?string $heading = 'Ulasan Peserta';

    protected ?string $subheading = 'Pantau penilaian dan komentar dari peserta trip.';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Ulasan')
                ->icon('lucide-plus'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ReviewStatsWidget::class,
        ];
    }
}
