<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar_url')
                    ->label('')
                    ->circular()
                    ->size(36),
                TextColumn::make('name')
                    ->label('Pengguna')
                    ->description(fn ($record) => $record->email)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->label('Telepon')
                    ->searchable()
                    ->placeholder('-')
                    ->toggleable(),
                TextColumn::make('role')
                    ->label('Role')
                    ->badge()
                    ->icon(fn (string $state) => match ($state) {
                        'admin' => 'lucide-shield',
                        default => 'lucide-user',
                    })
                    ->color(fn (string $state) => match ($state) {
                        'admin' => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('email_verified_at')
                    ->label('Verifikasi')
                    ->dateTime('d M Y')
                    ->placeholder('Belum terverifikasi')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Bergabung')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->label('Role')
                    ->options([
                        'user'  => 'User',
                        'admin' => 'Admin',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
