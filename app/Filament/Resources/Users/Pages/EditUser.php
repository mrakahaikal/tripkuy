<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected ?string $heading = 'Edit Pengguna';

    protected ?string $subheading = 'Perbarui data dan hak akses pengguna.';

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Hapus Pengguna')
                ->icon('lucide-trash-2'),
        ];
    }
}
