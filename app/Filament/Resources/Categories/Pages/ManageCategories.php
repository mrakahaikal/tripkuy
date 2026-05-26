<?php

namespace App\Filament\Resources\Categories\Pages;

use App\Filament\Resources\Categories\CategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageCategories extends ManageRecords
{
    protected static string $resource = CategoryResource::class;

    protected ?string $heading = 'Kategori Trip';

    protected ?string $subheading = 'Kelola pengelompokan trip berdasarkan jenis perjalanan.';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Kategori')
                ->icon('lucide-folder-plus'),
        ];
    }
}
