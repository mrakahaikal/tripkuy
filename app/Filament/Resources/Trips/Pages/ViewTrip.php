<?php

namespace App\Filament\Resources\Trips\Pages;

use App\Filament\Resources\Trips\TripResource;
use App\Mail\TripCancelledEmail;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ViewTrip extends ViewRecord
{
    protected static string $resource = TripResource::class;

    protected ?string $heading = 'Detail Trip';

    protected ?string $subheading = 'Informasi lengkap trip dan jadwal perjalanan.';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('publish')
                ->label('Publish')
                ->icon('lucide-eye')
                ->color('success')
                ->visible(fn (): bool => $this->record->status === 'draft')
                ->requiresConfirmation()
                ->modalHeading('Publish trip ini?')
                ->modalDescription('Trip akan langsung terlihat oleh publik.')
                ->action(function (): void {
                    $this->record->update(['status' => 'published']);
                    $this->redirect(static::getUrl(['record' => $this->record]));
                    Notification::make()->title('Trip dipublish')->success()->send();
                }),

            Action::make('unpublish')
                ->label('Unpublish')
                ->icon('lucide-eye-off')
                ->color('gray')
                ->visible(fn (): bool => $this->record->status === 'published')
                ->requiresConfirmation()
                ->modalHeading('Unpublish trip ini?')
                ->modalDescription('Trip tidak akan terlihat oleh publik.')
                ->action(function (): void {
                    $this->record->update(['status' => 'draft']);
                    $this->redirect(static::getUrl(['record' => $this->record]));
                    Notification::make()->title('Trip di-unpublish')->success()->send();
                }),

            Action::make('cancelTrip')
                ->label('Batalkan Trip')
                ->icon('lucide-x-circle')
                ->color('danger')
                ->visible(fn (): bool => in_array($this->record->status, ['draft', 'published']))
                ->requiresConfirmation()
                ->modalHeading('Batalkan trip ini?')
                ->modalDescription('Semua booking pending pada trip ini akan otomatis dibatalkan.')
                ->action(function (): void {
                    $affectedBookings = $this->record->bookings()
                        ->whereIn('status', ['pending', 'confirmed'])
                        ->with('user')
                        ->get();

                    DB::transaction(function (): void {
                        $this->record->update(['status' => 'cancelled']);
                        $this->record->bookings()->whereIn('status', ['pending', 'confirmed'])->update([
                            'status'       => 'cancelled',
                            'cancelled_at' => now(),
                        ]);
                    });

                    foreach ($affectedBookings as $booking) {
                        Mail::to($booking->user)->send(new TripCancelledEmail($booking));
                    }

                    $this->redirect(static::getUrl(['record' => $this->record]));
                    Notification::make()->title('Trip dibatalkan')->warning()->send();
                }),

            Action::make('complete')
                ->label('Tandai Selesai')
                ->icon('lucide-check-circle')
                ->color('info')
                ->visible(fn (): bool => $this->record->status === 'published' && $this->record->end_date->isPast())
                ->requiresConfirmation()
                ->modalHeading('Tandai trip sebagai selesai?')
                ->action(function (): void {
                    $this->record->update(['status' => 'completed']);
                    $this->redirect(static::getUrl(['record' => $this->record]));
                    Notification::make()->title('Trip ditandai selesai')->success()->send();
                }),

            EditAction::make()
                ->label('Edit Trip')
                ->icon('lucide-pencil'),
        ];
    }
}
