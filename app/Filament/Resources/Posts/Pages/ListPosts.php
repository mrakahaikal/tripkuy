<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use App\Filament\Resources\Posts\Widgets\PostStatsWidget;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected ?string $heading = 'Daftar Artikel';

    protected ?string $subheading = 'Tulis dan kelola konten blog perjalanan.';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tulis Artikel')
                ->icon('lucide-plus'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PostStatsWidget::class,
        ];
    }
}
