<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewPost extends ViewRecord
{
    protected static string $resource = PostResource::class;

    protected ?string $heading = 'Detail Artikel';

    protected ?string $subheading = 'Pratinjau artikel dan informasi publikasi.';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('publish')
                ->label('Publish')
                ->icon('lucide-send')
                ->color('success')
                ->visible(fn (): bool => in_array($this->record->status, ['draft', 'archived']))
                ->requiresConfirmation()
                ->modalHeading('Publish artikel ini?')
                ->modalDescription('Artikel akan langsung terlihat oleh publik.')
                ->action(function (): void {
                    $this->record->update([
                        'status'       => 'published',
                        'published_at' => $this->record->published_at ?? now(),
                    ]);
                    $this->redirect(static::getUrl(['record' => $this->record]));
                    Notification::make()->title('Artikel dipublish')->success()->send();
                }),

            Action::make('archive')
                ->label('Arsipkan')
                ->icon('lucide-archive')
                ->color('warning')
                ->visible(fn (): bool => $this->record->status === 'published')
                ->requiresConfirmation()
                ->modalHeading('Arsipkan artikel ini?')
                ->modalDescription('Artikel tidak akan terlihat oleh publik.')
                ->action(function (): void {
                    $this->record->update(['status' => 'archived']);
                    $this->redirect(static::getUrl(['record' => $this->record]));
                    Notification::make()->title('Artikel diarsipkan')->warning()->send();
                }),

            EditAction::make()
                ->label('Edit Artikel')
                ->icon('lucide-pencil'),
        ];
    }
}
