<?php

namespace App\Filament\Resources\Trips\Pages;

use App\Filament\Resources\Trips\TripResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTrip extends CreateRecord
{
    protected static string $resource = TripResource::class;

    protected ?string $heading = 'Tambah Trip Baru';

    protected ?string $subheading = 'Isi detail perjalanan untuk ditampilkan kepada calon peserta.';
}
