<?php

namespace App\Filament\Resources\Bookings\Pages;

use App\Filament\Resources\Bookings\BookingResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditBooking extends EditRecord
{
    protected static string $resource = BookingResource::class;

    protected ?string $heading = 'Edit Booking';

    protected ?string $subheading = 'Perbarui detail dan status pemesanan.';

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()
                ->label('Lihat Detail')
                ->icon('lucide-eye'),
            DeleteAction::make()
                ->label('Hapus Booking')
                ->icon('lucide-trash-2'),
        ];
    }
}
