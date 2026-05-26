<?php

namespace App\Filament\Resources\Trips\Widgets;

use App\Models\Trip;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TripStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Trip', Trip::count())
                ->description('Semua trip yang terdaftar')
                ->descriptionIcon('lucide-map')
                ->color('gray'),
            Stat::make('Dipublish', Trip::where('status', 'published')->count())
                ->description('Trip aktif & dapat dipesan')
                ->descriptionIcon('lucide-eye')
                ->color('success'),
            Stat::make('Mendatang', Trip::where('status', 'published')->where('start_date', '>=', now())->count())
                ->description('Trip yang akan datang')
                ->descriptionIcon('lucide-calendar')
                ->color('info'),
            Stat::make('Selesai', Trip::where('status', 'completed')->count())
                ->description('Trip yang sudah selesai')
                ->descriptionIcon('lucide-check')
                ->color('gray'),
        ];
    }
}
