<?php

namespace App\Filament\Resources\Trips\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ItinerariesRelationManager extends RelationManager
{
    protected static string $relationship = 'itineraries';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('day')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->prefix('Hari ke-'),
                TextInput::make('title')
                    ->required()
                    ->columnSpan(2),
                Textarea::make('description')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('day')
                    ->prefix('Hari ')
                    ->sortable(),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('description')
                    ->limit(60)
                    ->placeholder('-'),
            ])
            ->defaultSort('day')
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
