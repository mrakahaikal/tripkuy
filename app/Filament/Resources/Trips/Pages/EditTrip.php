<?php

namespace App\Filament\Resources\Trips\Pages;

use App\Filament\Resources\Trips\TripResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTrip extends EditRecord
{
    protected static string $resource = TripResource::class;

    protected ?string $heading = 'Edit Trip';

    protected ?string $subheading = 'Perbarui informasi trip yang sudah terdaftar.';

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()
                ->label('Lihat Detail')
                ->icon('lucide-eye'),
            DeleteAction::make()
                ->label('Hapus Trip')
                ->icon('lucide-trash-2'),
        ];
    }
}
