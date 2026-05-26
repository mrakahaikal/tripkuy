<?php

namespace App\Filament\Resources\Reviews;

use App\Filament\Resources\Reviews\Pages\ManageReviews;
use App\Models\Review;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedStar;

    protected static ?string $navigationLabel = 'Ulasan';

    protected static string|\UnitEnum|null $navigationGroup = 'Konten';

    protected static ?string $recordTitleAttribute = 'comment';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Informasi Review')
                    ->description('Penilaian dan komentar yang diberikan oleh peserta trip.')
                    ->icon('lucide-star')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('trip.title')
                            ->label('Trip'),
                        TextEntry::make('user.name')
                            ->label('Peserta'),
                        TextEntry::make('rating')
                            ->label('Rating')
                            ->formatStateUsing(fn (int $state) => str_repeat('★', $state).str_repeat('☆', 5 - $state))
                            ->columnSpanFull(),
                        TextEntry::make('comment')
                            ->label('Komentar')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('created_at')
                            ->label('Tanggal')
                            ->dateTime('d M Y H:i'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('trip.title')
                    ->label('Trip')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                TextColumn::make('user.name')
                    ->label('Peserta')
                    ->searchable(),
                TextColumn::make('rating')
                    ->label('Rating')
                    ->formatStateUsing(fn (int $state) => str_repeat('★', $state).str_repeat('☆', 5 - $state))
                    ->sortable(),
                TextColumn::make('comment')
                    ->label('Komentar')
                    ->limit(60)
                    ->placeholder('-'),
                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('rating')
                    ->options([
                        '5' => '★★★★★',
                        '4' => '★★★★☆',
                        '3' => '★★★☆☆',
                        '2' => '★★☆☆☆',
                        '1' => '★☆☆☆☆',
                    ]),
                SelectFilter::make('trip')
                    ->relationship('trip', 'title'),
            ])
            ->recordActions([
                ViewAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageReviews::route('/'),
        ];
    }
}
