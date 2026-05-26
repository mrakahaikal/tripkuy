<?php

namespace App\Filament\Resources\Reviews\Widgets;

use App\Models\Review;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ReviewStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $avgRating = number_format(Review::avg('rating') ?? 0, 1);

        return [
            Stat::make('Total Ulasan', Review::count())
                ->description('Semua ulasan dari peserta')
                ->descriptionIcon('lucide-star')
                ->color('gray'),
            Stat::make('Rating Rata-rata', $avgRating.' / 5')
                ->description('Rata-rata dari semua ulasan')
                ->descriptionIcon('lucide-star')
                ->color('success'),
            Stat::make('Bintang 5', Review::where('rating', 5)->count())
                ->description('Ulasan dengan rating tertinggi')
                ->descriptionIcon('lucide-star')
                ->color('warning'),
            Stat::make('Bulan Ini', Review::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count())
                ->description('Ulasan masuk bulan ini')
                ->descriptionIcon('lucide-calendar')
                ->color('info'),
        ];
    }
}
