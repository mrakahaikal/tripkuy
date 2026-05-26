<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PostInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Meta Artikel')
                    ->description('Identitas, kategori, dan status publikasi artikel.')
                    ->icon('lucide-settings')
                    ->columns(2)
                    ->schema([
                        ImageEntry::make('cover_image')
                            ->label('')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('title')
                            ->label('Judul')
                            ->columnSpanFull(),
                        TextEntry::make('category.name')
                            ->label('Kategori')
                            ->badge(),
                        TextEntry::make('author.name')
                            ->label('Penulis'),
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->icon(fn (string $state): ?string => match ($state) {
                                'draft' => 'lucide-pencil',
                                'published' => 'lucide-eye',
                                'archived' => 'lucide-archive',
                                default => null,
                            })
                            ->color(fn (string $state): string => match ($state) {
                                'draft' => 'gray',
                                'published' => 'success',
                                'archived' => 'warning',
                                default => 'gray',
                            }),
                        TextEntry::make('published_at')
                            ->label('Dipublish')
                            ->dateTime('d M Y H:i')
                            ->placeholder('-'),
                    ]),

                Section::make('Konten Artikel')
                    ->description('Ringkasan singkat dan isi lengkap artikel.')
                    ->icon('lucide-file-text')
                    ->schema([
                        TextEntry::make('excerpt')
                            ->label('Ringkasan')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('content')
                            ->label('Konten')
                            ->html()
                            ->columnSpanFull(),
                    ]),

                Section::make('Audit')
                    ->description('Waktu pembuatan dan pembaruan artikel.')
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
