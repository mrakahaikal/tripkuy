<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected ?string $heading = 'Edit Artikel';

    protected ?string $subheading = 'Perbarui konten dan detail artikel.';

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()
                ->label('Lihat Artikel')
                ->icon('lucide-eye'),
            DeleteAction::make()
                ->label('Hapus Artikel')
                ->icon('lucide-trash-2'),
        ];
    }
}
