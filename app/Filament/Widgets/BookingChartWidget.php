<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\ChartWidget;

class BookingChartWidget extends ChartWidget
{
    protected static ?int $sort = 1;

    protected ?string $heading = 'Tren Pemesanan';

    protected int|string|array $columnSpan = 'full';

    protected ?string $pollingInterval = null;

    public ?string $filter = '6';

    protected function getFilters(): ?array
    {
        return [
            '6' => '6 Bulan Terakhir',
            '12' => '12 Bulan Terakhir',
        ];
    }

    protected function getData(): array
    {
        $months = (int) ($this->filter ?? 6);

        $data = collect(range($months - 1, 0))->map(function ($i) {
            $date = now()->subMonths($i);

            return [
                'label' => $date->format('M Y'),
                'confirmed' => Booking::where('status', 'confirmed')
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
                'pending' => Booking::where('status', 'pending')
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
            ];
        });

        return [
            'datasets' => [
                [
                    'label' => 'Dikonfirmasi',
                    'data' => $data->pluck('confirmed')->toArray(),
                    'backgroundColor' => 'rgba(20, 184, 166, 0.8)',
                    'borderColor' => '#0d9488',
                    'borderWidth' => 2,
                ],
                [
                    'label' => 'Menunggu',
                    'data' => $data->pluck('pending')->toArray(),
                    'backgroundColor' => 'rgba(251, 191, 36, 0.6)',
                    'borderColor' => '#d97706',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $data->pluck('label')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
