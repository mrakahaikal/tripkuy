<?php

namespace App\Filament\Resources\Bookings\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Detail Pemesanan')
                    ->description('Identitas booking beserta pemesan dan trip yang dipilih.')
                    ->icon('lucide-ticket')
                    ->columns(2)
                    ->schema([
                        TextInput::make('booking_code')
                            ->label('Kode Booking')
                            ->placeholder('mis. TK-2024-001')
                            ->helperText('Kode unik pemesanan. Tidak dapat diubah setelah dibuat.')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->disabled(fn ($record) => $record !== null),
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending'   => 'Pending',
                                'confirmed' => 'Confirmed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->helperText('Status terkini proses pemesanan.')
                            ->required()
                            ->default('pending'),
                        Select::make('user_id')
                            ->label('Pemesan')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->helperText('Pengguna yang melakukan pemesanan.')
                            ->required(),
                        Select::make('trip_id')
                            ->label('Trip')
                            ->relationship('trip', 'title')
                            ->searchable()
                            ->preload()
                            ->helperText('Trip yang dipesan.')
                            ->required(),
                    ]),

                Section::make('Peserta & Harga')
                    ->description('Jumlah peserta dan total biaya yang harus dibayar.')
                    ->icon('lucide-users')
                    ->columns(2)
                    ->schema([
                        TextInput::make('participant_count')
                            ->label('Jumlah Peserta')
                            ->placeholder('mis. 2')
                            ->helperText('Jumlah orang yang ikut dalam booking ini.')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->suffix('orang'),
                        TextInput::make('total_price')
                            ->label('Total Harga')
                            ->placeholder('mis. 2500000')
                            ->helperText('Total biaya keseluruhan sesuai jumlah peserta.')
                            ->required()
                            ->numeric()
                            ->prefix('Rp'),
                    ]),

                Section::make('Batas Waktu & Catatan')
                    ->description('Informasi tambahan terkait pembayaran dan permintaan khusus.')
                    ->icon('lucide-clock')
                    ->columns(2)
                    ->schema([
                        DateTimePicker::make('payment_deadline')
                            ->label('Batas Waktu Bayar')
                            ->placeholder('Pilih tanggal & waktu...')
                            ->helperText('Kosongkan jika tidak ada batas waktu pembayaran.')
                            ->native(false)
                            ->columnSpanFull(),
                        Textarea::make('notes')
                            ->label('Catatan')
                            ->placeholder('Catatan dari pemesan atau permintaan khusus...')
                            ->helperText('Opsional. Permintaan khusus, alergi, kebutuhan khusus, dll.')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
