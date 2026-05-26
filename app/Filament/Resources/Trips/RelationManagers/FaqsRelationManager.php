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

class FaqsRelationManager extends RelationManager
{
    protected static string $relationship = 'faqs';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('order')
                    ->label('Urutan')
                    ->numeric()
                    ->default(0),
                TextInput::make('question')
                    ->label('Pertanyaan')
                    ->required()
                    ->columnSpan(2),
                Textarea::make('answer')
                    ->label('Jawaban')
                    ->required()
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('question')
            ->columns([
                TextColumn::make('order')
                    ->label('#')
                    ->sortable(),
                TextColumn::make('question')
                    ->label('Pertanyaan')
                    ->searchable()
                    ->limit(60),
                TextColumn::make('answer')
                    ->label('Jawaban')
                    ->limit(80)
                    ->placeholder('-'),
            ])
            ->defaultSort('order')
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
