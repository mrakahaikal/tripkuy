<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\Trip;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatsWidget extends BaseWidget
{
    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        $newUsersThisMonth = User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $bookingsThisMonth = Booking::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $revenueThisMonth = Booking::where('status', 'confirmed')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_price');

        $bookingSparkline = collect(range(6, 0))
            ->map(fn ($i) => Booking::whereDate('created_at', now()->subDays($i))->count())
            ->toArray();

        return [
            Stat::make('Total Pengguna', User::count())
                ->description($newUsersThisMonth.' bergabung bulan ini')
                ->descriptionIcon('lucide-user-plus')
                ->color('info'),

            Stat::make('Trip Aktif', Trip::where('status', 'published')->count())
                ->description(Trip::where('status', 'published')->where('start_date', '>=', now())->count().' trip mendatang')
                ->descriptionIcon('lucide-map')
                ->color('success'),

            Stat::make('Booking Bulan Ini', $bookingsThisMonth)
                ->description('Semua status pemesanan')
                ->descriptionIcon('lucide-ticket')
                ->chart($bookingSparkline)
                ->color('warning'),

            Stat::make('Pendapatan Bulan Ini', 'Rp '.number_format($revenueThisMonth, 0, ',', '.'))
                ->description('Dari booking terkonfirmasi')
                ->descriptionIcon('lucide-circle-dollar-sign')
                ->color('success'),
        ];
    }
}
