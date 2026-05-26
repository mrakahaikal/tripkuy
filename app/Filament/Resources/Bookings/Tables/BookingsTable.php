<?php

namespace App\Filament\Resources\Bookings\Tables;

use App\Mail\BookingCancelledEmail;
use App\Models\Booking;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Mail;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class BookingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('booking_code')
                    ->label('Kode Booking')
                    ->searchable()
                    ->copyable()
                    ->fontFamily('mono'),
                TextColumn::make('user.name')
                    ->label('Pemesan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('trip.title')
                    ->label('Trip')
                    ->searchable()
                    ->sortable()
                    ->limit(35),
                TextColumn::make('participant_count')
                    ->label('Peserta')
                    ->suffix(' orang')
                    ->sortable(),
                TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->icon(fn (string $state) => match ($state) {
                        'pending'   => 'lucide-clock',
                        'confirmed' => 'lucide-check',
                        'cancelled' => 'lucide-x',
                        default     => null,
                    })
                    ->color(fn (string $state) => match ($state) {
                        'pending'   => 'warning',
                        'confirmed' => 'success',
                        'cancelled' => 'danger',
                        default     => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Tanggal Pesan')
                    ->dateTime('d M Y')
                    ->sortable(),
                TextColumn::make('confirmed_at')
                    ->label('Dikonfirmasi')
                    ->dateTime('d M Y')
                    ->placeholder('-')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending'   => 'Pending',
                        'confirmed' => 'Confirmed',
                        'cancelled' => 'Cancelled',
                    ]),
                SelectFilter::make('trip')
                    ->label('Trip')
                    ->relationship('trip', 'title'),
            ])
            ->recordActions([
                Action::make('cancelBooking')
                    ->label('Batalkan')
                    ->icon('lucide-x-circle')
                    ->color('danger')
                    ->visible(fn (Booking $record): bool => in_array($record->status, ['pending', 'confirmed']))
                    ->requiresConfirmation()
                    ->modalHeading('Batalkan booking ini?')
                    ->modalDescription('Tindakan ini tidak dapat dibatalkan. Payment pending akan otomatis ditolak.')
                    ->modalSubmitActionLabel('Ya, Batalkan')
                    ->schema([
                        Textarea::make('notes')
                            ->label('Alasan Pembatalan')
                            ->placeholder('Opsional — alasan pembatalan untuk dicatat.')
                            ->rows(2),
                    ])
                    ->action(function (Booking $record, array $data): void {
                        DB::transaction(function () use ($record, $data): void {
                            $record->update([
                                'status'       => 'cancelled',
                                'cancelled_at' => now(),
                                'notes'        => $data['notes'] ?? $record->notes,
                            ]);
                            $record->payments()->where('status', 'pending')->update(['status' => 'rejected']);
                        });
                        Mail::to($record->user)->send(new BookingCancelledEmail($record, $data['notes'] ?? null));
                        Notification::make()->title('Booking dibatalkan')->warning()->send();
                    }),
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                ])
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
