<?php

namespace App\Filament\Resources\Trips\Tables;

use App\Mail\TripCancelledEmail;
use App\Models\Trip;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TripsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover_image')
                    ->label('')
                    ->square()
                    ->imageSize(48),
                TextColumn::make('title')
                    ->label('Trip')
                    ->description(fn ($record) => $record->departure_city . ' → ' . $record->destination)
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->sortable(),
                TextColumn::make('start_date')
                    ->label('Berangkat')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->icon(fn (string $state) => match ($state) {
                        'draft'     => 'lucide-pencil',
                        'published' => 'lucide-eye',
                        'full'      => 'lucide-users',
                        'cancelled' => 'lucide-x',
                        'completed' => 'lucide-check',
                        default     => null,
                    })
                    ->color(fn (string $state) => match ($state) {
                        'published' => 'success',
                        'full'      => 'warning',
                        'cancelled' => 'danger',
                        'completed' => 'info',
                        default     => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('difficulty_level')
                    ->label('Kesulitan')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'easy'     => 'success',
                        'moderate' => 'warning',
                        'hard'     => 'danger',
                        default    => 'gray',
                    })
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('quota')
                    ->label('Kuota')
                    ->suffix(' orang')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('duration_days')
                    ->label('Durasi')
                    ->suffix(' hari')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                        'full'      => 'Full',
                        'cancelled' => 'Cancelled',
                        'completed' => 'Completed',
                    ]),
                SelectFilter::make('category')
                    ->label('Kategori')
                    ->relationship('category', 'name'),
                SelectFilter::make('difficulty_level')
                    ->label('Kesulitan')
                    ->options([
                        'easy'     => 'Easy',
                        'moderate' => 'Moderate',
                        'hard'     => 'Hard',
                    ]),
            ])
            ->recordActions([
                Action::make('publish')
                    ->label('Publish')
                    ->icon('lucide-eye')
                    ->color('success')
                    ->visible(fn (Trip $record): bool => $record->status === 'draft')
                    ->requiresConfirmation()
                    ->modalHeading('Publish trip ini?')
                    ->modalDescription('Trip akan langsung terlihat oleh publik.')
                    ->action(function (Trip $record): void {
                        $record->update(['status' => 'published']);
                        Notification::make()->title('Trip dipublish')->success()->send();
                    }),

                Action::make('unpublish')
                    ->label('Unpublish')
                    ->icon('lucide-eye-off')
                    ->color('gray')
                    ->visible(fn (Trip $record): bool => $record->status === 'published')
                    ->requiresConfirmation()
                    ->modalHeading('Unpublish trip ini?')
                    ->modalDescription('Trip tidak akan terlihat oleh publik.')
                    ->action(function (Trip $record): void {
                        $record->update(['status' => 'draft']);
                        Notification::make()->title('Trip di-unpublish')->success()->send();
                    }),

                Action::make('cancelTrip')
                    ->label('Batalkan')
                    ->icon('lucide-x-circle')
                    ->color('danger')
                    ->visible(fn (Trip $record): bool => in_array($record->status, ['draft', 'published']))
                    ->requiresConfirmation()
                    ->modalHeading('Batalkan trip ini?')
                    ->modalDescription('Semua booking pending pada trip ini akan otomatis dibatalkan.')
                    ->action(function (Trip $record): void {
                        $affectedBookings = $record->bookings()
                            ->whereIn('status', ['pending', 'confirmed'])
                            ->with('user')
                            ->get();

                        DB::transaction(function () use ($record): void {
                            $record->update(['status' => 'cancelled']);
                            $record->bookings()->whereIn('status', ['pending', 'confirmed'])->update([
                                'status'       => 'cancelled',
                                'cancelled_at' => now(),
                            ]);
                        });

                        foreach ($affectedBookings as $booking) {
                            Mail::to($booking->user)->send(new TripCancelledEmail($booking));
                        }

                        Notification::make()->title('Trip dibatalkan')->warning()->send();
                    }),

                Action::make('complete')
                    ->label('Tandai Selesai')
                    ->icon('lucide-check-circle')
                    ->color('info')
                    ->visible(fn (Trip $record): bool => $record->status === 'published' && $record->end_date->isPast())
                    ->requiresConfirmation()
                    ->modalHeading('Tandai trip sebagai selesai?')
                    ->action(function (Trip $record): void {
                        $record->update(['status' => 'completed']);
                        Notification::make()->title('Trip ditandai selesai')->success()->send();
                    }),

                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('bulkPublish')
                        ->label('Publish')
                        ->icon('lucide-eye')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Publish trip yang dipilih?')
                        ->modalDescription('Hanya trip berstatus draft yang akan diubah.')
                        ->action(function (Collection $records): void {
                            $records->where('status', 'draft')->each->update(['status' => 'published']);
                            Notification::make()->title('Trip dipublish')->success()->send();
                        }),

                    BulkAction::make('bulkUnpublish')
                        ->label('Unpublish')
                        ->icon('lucide-eye-off')
                        ->color('gray')
                        ->requiresConfirmation()
                        ->modalHeading('Unpublish trip yang dipilih?')
                        ->modalDescription('Hanya trip berstatus published yang akan diubah.')
                        ->action(function (Collection $records): void {
                            $records->where('status', 'published')->each->update(['status' => 'draft']);
                            Notification::make()->title('Trip di-unpublish')->success()->send();
                        }),

                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('start_date', 'asc');
    }
}
