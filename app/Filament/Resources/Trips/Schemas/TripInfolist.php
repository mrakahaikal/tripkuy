<?php

namespace App\Filament\Resources\Trips\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TripInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Ringkasan Trip')
                    ->description('Gambaran umum dan identitas trip yang ditampilkan kepada peserta.')
                    ->icon('lucide-map')
                    ->columns(2)
                    ->schema([
                        ImageEntry::make('cover_image')
                            ->label('')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('title')
                            ->label('Nama Trip')
                            ->columnSpanFull(),
                        TextEntry::make('category.name')
                            ->label('Kategori')
                            ->badge(),
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->icon(fn (string $state): ?string => match ($state) {
                                'draft' => 'lucide-pencil',
                                'published' => 'lucide-eye',
                                'full' => 'lucide-users',
                                'cancelled' => 'lucide-x',
                                'completed' => 'lucide-check',
                                default => null,
                            })
                            ->color(fn (string $state): string => match ($state) {
                                'draft' => 'gray',
                                'published' => 'success',
                                'full' => 'warning',
                                'cancelled' => 'danger',
                                'completed' => 'info',
                                default => 'gray',
                            }),
                        TextEntry::make('difficulty_level')
                            ->label('Tingkat Kesulitan')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'easy' => 'success',
                                'moderate' => 'warning',
                                'hard' => 'danger',
                                default => 'gray',
                            }),
                        TextEntry::make('highlight')
                            ->label('Highlight')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),

                Section::make('Lokasi & Jadwal')
                    ->description('Informasi keberangkatan, tujuan, dan jadwal perjalanan.')
                    ->icon('lucide-map-pin')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('destination')
                            ->label('Tujuan'),
                        TextEntry::make('departure_city')
                            ->label('Kota Keberangkatan'),
                        TextEntry::make('meeting_point')
                            ->label('Titik Kumpul')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('start_date')
                            ->label('Tanggal Berangkat')
                            ->date('d M Y'),
                        TextEntry::make('end_date')
                            ->label('Tanggal Kembali')
                            ->date('d M Y'),
                        TextEntry::make('duration_days')
                            ->label('Durasi')
                            ->suffix(' hari'),
                    ]),

                Section::make('Harga & Kuota')
                    ->description('Detail harga per orang dan kapasitas peserta.')
                    ->icon('lucide-circle-dollar-sign')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('price')
                            ->label('Harga / Orang')
                            ->money('IDR'),
                        TextEntry::make('quota')
                            ->label('Kuota')
                            ->suffix(' orang'),
                        TextEntry::make('min_participants')
                            ->label('Min. Peserta')
                            ->suffix(' orang'),
                    ]),

                Section::make('Deskripsi')
                    ->description('Penjelasan lengkap, fasilitas yang termasuk, dan ketentuan trip.')
                    ->icon('lucide-file-text')
                    ->schema([
                        TextEntry::make('description')
                            ->label('Deskripsi')
                            ->columnSpanFull(),
                        TextEntry::make('includes')
                            ->label('Sudah Termasuk')
                            ->listWithLineBreaks()
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('excludes')
                            ->label('Tidak Termasuk')
                            ->listWithLineBreaks()
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),

                Section::make('Audit')
                    ->description('Waktu pembuatan dan pembaruan data trip.')
                    ->icon('lucide-clock')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Dibuat')
                            ->dateTime('d M Y H:i'),
                        TextEntry::make('updated_at')
                            ->label('Diperbarui')
                            ->dateTime('d M Y H:i'),
                    ]),
            ]);
    }
}
