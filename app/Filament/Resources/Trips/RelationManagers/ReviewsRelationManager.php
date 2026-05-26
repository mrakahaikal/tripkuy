<?php

namespace App\Filament\Resources\Trips\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ReviewsRelationManager extends RelationManager
{
    protected static string $relationship = 'reviews';

    public function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('comment')
            ->columns([
                TextColumn::make('user.name')
                    ->label('Peserta')
                    ->searchable(),
                TextColumn::make('rating')
                    ->label('Rating')
                    ->formatStateUsing(fn (int $state) => str_repeat('★', $state) . str_repeat('☆', 5 - $state))
                    ->sortable(),
                TextColumn::make('comment')
                    ->label('Komentar')
                    ->limit(80)
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
}
