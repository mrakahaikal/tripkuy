<?php

namespace App\Filament\Resources\Bookings\Widgets;

use App\Models\Booking;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BookingStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $revenue = Booking::where('status', 'confirmed')->sum('total_price');

        return [
            Stat::make('Total Booking', Booking::count())
                ->description('Semua pemesanan')
                ->descriptionIcon('lucide-ticket')
                ->color('gray'),
            Stat::make('Menunggu', Booking::where('status', 'pending')->count())
                ->description('Menunggu konfirmasi')
                ->descriptionIcon('lucide-clock')
                ->color('warning'),
            Stat::make('Dikonfirmasi', Booking::where('status', 'confirmed')->count())
                ->description('Booking telah dikonfirmasi')
                ->descriptionIcon('lucide-check')
                ->color('success'),
            Stat::make('Total Pendapatan', 'Rp '.number_format($revenue, 0, ',', '.'))
                ->description('Dari booking terkonfirmasi')
                ->descriptionIcon('lucide-circle-dollar-sign')
                ->color('success'),
        ];
    }
}
