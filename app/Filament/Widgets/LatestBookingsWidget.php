<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestBookingsWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected static ?string $heading = 'Booking Terbaru';

    protected int|string|array $columnSpan = 'full';

    protected ?string $pollingInterval = null;

    public function table(Table $table): Table
    {
        return $table
            ->query(Booking::query()->with(['user', 'trip'])->latest()->limit(5))
            ->paginated(false)
            ->columns([
                TextColumn::make('booking_code')
                    ->label('Kode Booking')
                    ->fontFamily('mono')
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Pemesan')
                    ->sortable(),
                TextColumn::make('trip.title')
                    ->label('Trip')
                    ->limit(40),
                TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->icon(fn (string $state): ?string => match ($state) {
                        'pending' => 'lucide-clock',
                        'confirmed' => 'lucide-check',
                        'cancelled' => 'lucide-x',
                        default => null,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ]);
    }
}
