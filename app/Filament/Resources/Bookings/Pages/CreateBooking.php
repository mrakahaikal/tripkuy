<?php

namespace App\Filament\Resources\Bookings\Pages;

use App\Filament\Resources\Bookings\BookingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBooking extends CreateRecord
{
    protected static string $resource = BookingResource::class;

    protected ?string $heading = 'Buat Booking Baru';

    protected ?string $subheading = 'Input data pemesanan trip untuk peserta.';
}
