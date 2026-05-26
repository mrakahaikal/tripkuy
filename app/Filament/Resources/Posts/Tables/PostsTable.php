<?php

namespace App\Filament\Resources\Posts\Tables;

use App\Models\Post;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover_image')
                    ->label('')
                    ->square()
                    ->size(48),
                TextColumn::make('title')
                    ->label('Artikel')
                    ->description(fn ($record) => Str::limit($record->excerpt ?? '', 80))
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->sortable(),
                TextColumn::make('author.name')
                    ->label('Penulis')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->icon(fn (string $state) => match ($state) {
                        'draft'     => 'lucide-pencil',
                        'published' => 'lucide-eye',
                        'archived'  => 'lucide-archive',
                        default     => null,
                    })
                    ->color(fn (string $state) => match ($state) {
                        'draft'     => 'gray',
                        'published' => 'success',
                        'archived'  => 'warning',
                        default     => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('published_at')
                    ->label('Dipublish')
                    ->date('d M Y')
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'draft'     => 'Draft',
                        'published' => 'Published',
                        'archived'  => 'Archived',
                    ]),
                SelectFilter::make('category')
                    ->label('Kategori')
                    ->relationship('category', 'name'),
            ])
            ->recordActions([
                Action::make('publish')
                    ->label('Publish')
                    ->icon('lucide-send')
                    ->color('success')
                    ->visible(fn (Post $record): bool => in_array($record->status, ['draft', 'archived']))
                    ->requiresConfirmation()
                    ->modalHeading('Publish artikel ini?')
                    ->modalDescription('Artikel akan langsung terlihat oleh publik.')
                    ->action(function (Post $record): void {
                        $record->update([
                            'status'       => 'published',
                            'published_at' => $record->published_at ?? now(),
                        ]);
                        Notification::make()->title('Artikel dipublish')->success()->send();
                    }),

                Action::make('archive')
                    ->label('Arsipkan')
                    ->icon('lucide-archive')
                    ->color('warning')
                    ->visible(fn (Post $record): bool => $record->status === 'published')
                    ->requiresConfirmation()
                    ->modalHeading('Arsipkan artikel ini?')
                    ->modalDescription('Artikel tidak akan terlihat oleh publik.')
                    ->action(function (Post $record): void {
                        $record->update(['status' => 'archived']);
                        Notification::make()->title('Artikel diarsipkan')->warning()->send();
                    }),

                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
