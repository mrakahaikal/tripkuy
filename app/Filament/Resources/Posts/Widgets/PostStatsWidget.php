<?php

namespace App\Filament\Resources\Posts\Widgets;

use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PostStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Artikel', Post::count())
                ->description('Semua artikel di blog')
                ->descriptionIcon('lucide-newspaper')
                ->color('gray'),
            Stat::make('Dipublish', Post::where('status', 'published')->count())
                ->description('Artikel yang sudah tayang')
                ->descriptionIcon('lucide-eye')
                ->color('success'),
            Stat::make('Draft', Post::where('status', 'draft')->count())
                ->description('Artikel dalam proses penulisan')
                ->descriptionIcon('lucide-pencil')
                ->color('gray'),
            Stat::make('Diarsipkan', Post::where('status', 'archived')->count())
                ->description('Artikel yang diarsipkan')
                ->descriptionIcon('lucide-archive')
                ->color('warning'),
        ];
    }
}
