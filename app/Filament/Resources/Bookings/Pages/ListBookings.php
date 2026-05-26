<?php

namespace App\Filament\Resources\Bookings\Pages;

use App\Filament\Resources\Bookings\BookingResource;
use App\Filament\Resources\Bookings\Widgets\BookingStatsWidget;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBookings extends ListRecords
{
    protected static string $resource = BookingResource::class;

    protected ?string $heading = 'Daftar Pemesanan';

    protected ?string $subheading = 'Pantau semua transaksi booking peserta.';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Buat Booking')
                ->icon('lucide-plus'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            BookingStatsWidget::class,
        ];
    }
}
