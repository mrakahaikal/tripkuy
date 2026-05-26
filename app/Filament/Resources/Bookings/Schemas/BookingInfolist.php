<?php

namespace App\Filament\Resources\Bookings\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BookingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Detail Pemesanan')
                    ->description('Identitas booking dan status pemesanan saat ini.')
                    ->icon('lucide-ticket')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('booking_code')
                            ->label('Kode Booking')
                            ->copyable()
                            ->fontFamily('mono'),
                        TextEntry::make('status')
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
                    ]),

                Section::make('Pemesan & Trip')
                    ->description('Informasi tentang pemesan dan trip yang dipesan.')
                    ->icon('lucide-users')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('Pemesan'),
                        TextEntry::make('trip.title')
                            ->label('Trip'),
                    ]),

                Section::make('Peserta & Harga')
                    ->description('Jumlah peserta, total tagihan, dan catatan pemesanan.')
                    ->icon('lucide-circle-dollar-sign')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('participant_count')
                            ->label('Jumlah Peserta')
                            ->suffix(' orang'),
                        TextEntry::make('total_price')
                            ->label('Total Harga')
                            ->money('IDR'),
                        TextEntry::make('notes')
                            ->label('Catatan')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),

                Section::make('Timeline')
                    ->description('Riwayat waktu pemesanan, konfirmasi, dan pembatalan.')
                    ->icon('lucide-calendar')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Tanggal Pesan')
                            ->dateTime('d M Y H:i'),
                        TextEntry::make('payment_deadline')
                            ->label('Batas Waktu Bayar')
                            ->dateTime('d M Y H:i')
                            ->placeholder('-'),
                        TextEntry::make('confirmed_at')
                            ->label('Dikonfirmasi')
                            ->dateTime('d M Y H:i')
                            ->placeholder('-'),
                        TextEntry::make('cancelled_at')
                            ->label('Dibatalkan')
                            ->dateTime('d M Y H:i')
                            ->placeholder('-'),
                    ]),
            ]);
    }
}
