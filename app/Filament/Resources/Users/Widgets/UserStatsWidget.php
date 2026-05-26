<?php

namespace App\Filament\Resources\Users\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Pengguna', User::count())
                ->description('Semua pengguna terdaftar')
                ->descriptionIcon('lucide-users')
                ->color('gray'),
            Stat::make('Admin', User::where('role', 'admin')->count())
                ->description('Pengguna dengan akses admin')
                ->descriptionIcon('lucide-shield')
                ->color('warning'),
            Stat::make('Terverifikasi', User::whereNotNull('email_verified_at')->count())
                ->description('Email sudah diverifikasi')
                ->descriptionIcon('lucide-check')
                ->color('success'),
            Stat::make('Bergabung Bulan Ini', User::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count())
                ->description('Pengguna baru bulan ini')
                ->descriptionIcon('lucide-user-plus')
                ->color('info'),
        ];
    }
}
