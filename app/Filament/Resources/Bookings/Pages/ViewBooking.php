<?php

namespace App\Filament\Resources\Bookings\Pages;

use App\Filament\Resources\Bookings\BookingResource;
use App\Mail\BookingCancelledEmail;
use App\Mail\BookingConfirmedEmail;
use App\Mail\PaymentRejectedEmail;
use App\Models\Payment;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Grid;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ViewBooking extends ViewRecord
{
    protected static string $resource = BookingResource::class;

    protected ?string $heading = 'Detail Booking';

    protected ?string $subheading = 'Informasi lengkap pemesanan dan status pembayaran.';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('approvePayment')
                ->label('Setujui Pembayaran')
                ->icon('lucide-check-circle')
                ->color('success')
                ->visible(fn (): bool => $this->record->status === 'pending'
                    && $this->record->payments()->where('status', 'pending')->exists()
                )
                ->modalHeading('Setujui Pembayaran')
                ->modalSubmitActionLabel('Ya, Setujui')
                ->infolist(function (): array {
                    /** @var Payment $payment */
                    $payment = $this->record->payments()->where('status', 'pending')->latest()->first();

                    return [
                        Grid::make(2)->schema([
                            TextEntry::make('amount')
                                ->label('Jumlah Transfer')
                                ->money('IDR')
                                ->state($payment?->amount),
                            TextEntry::make('payment_method')
                                ->label('Metode')
                                ->placeholder('-')
                                ->state($payment?->payment_method),
                            TextEntry::make('paid_at')
                                ->label('Waktu Transfer')
                                ->dateTime('d M Y H:i')
                                ->placeholder('-')
                                ->state($payment?->paid_at),
                        ]),
                        ImageEntry::make('proof_image')
                            ->label('Bukti Transfer')
                            ->disk('public')
                            ->height(320)
                            ->columnSpanFull()
                            ->state($payment?->proof_image),
                    ];
                })
                ->action(function (): void {
                    /** @var Payment|null $payment */
                    $payment = $this->record->payments()->where('status', 'pending')->latest()->first();

                    if (! $payment) {
                        return;
                    }

                    DB::transaction(function () use ($payment): void {
                        $payment->update([
                            'status'      => 'verified',
                            'verified_at' => now(),
                            'verified_by' => auth()->id(),
                        ]);
                        $this->record->update([
                            'status'       => 'confirmed',
                            'confirmed_at' => now(),
                        ]);
                    });

                    Mail::to($this->record->user)->send(new BookingConfirmedEmail($this->record));

                    $this->refreshFormData(['status', 'confirmed_at']);

                    Notification::make()
                        ->title('Pembayaran disetujui')
                        ->body('Booking telah dikonfirmasi.')
                        ->success()
                        ->send();
                }),

            Action::make('rejectPayment')
                ->label('Tolak Pembayaran')
                ->icon('lucide-x-circle')
                ->color('danger')
                ->visible(fn (): bool => $this->record->status === 'pending'
                    && $this->record->payments()->where('status', 'pending')->exists()
                )
                ->modalHeading('Tolak Pembayaran')
                ->modalSubmitActionLabel('Tolak Pembayaran')
                ->schema([
                    Textarea::make('notes')
                        ->label('Alasan Penolakan')
                        ->placeholder('mis. Jumlah transfer tidak sesuai dengan total tagihan.')
                        ->required()
                        ->rows(3),
                ])
                ->action(function (array $data): void {
                    /** @var Payment|null $payment */
                    $payment = $this->record->payments()->where('status', 'pending')->latest()->first();

                    if (! $payment) {
                        return;
                    }

                    $payment->update([
                        'status' => 'rejected',
                        'notes'  => $data['notes'],
                    ]);

                    Mail::to($this->record->user)->send(new PaymentRejectedEmail($this->record, $data['notes']));

                    Notification::make()
                        ->title('Pembayaran ditolak')
                        ->body('Alasan penolakan telah disimpan.')
                        ->warning()
                        ->send();
                }),

            Action::make('cancelBooking')
                ->label('Batalkan Booking')
                ->icon('lucide-ban')
                ->color('danger')
                ->visible(fn (): bool => in_array($this->record->status, ['pending', 'confirmed']))
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
                ->action(function (array $data): void {
                    DB::transaction(function () use ($data): void {
                        $this->record->update([
                            'status'       => 'cancelled',
                            'cancelled_at' => now(),
                            'notes'        => $data['notes'] ?? $this->record->notes,
                        ]);
                        $this->record->payments()->where('status', 'pending')->update(['status' => 'rejected']);
                    });

                    Mail::to($this->record->user)->send(new BookingCancelledEmail($this->record, $data['notes'] ?? null));

                    $this->redirect(static::getUrl(['record' => $this->record]));

                    Notification::make()
                        ->title('Booking dibatalkan')
                        ->warning()
                        ->send();
                }),

            EditAction::make()
                ->label('Edit Booking')
                ->icon('lucide-pencil'),
        ];
    }
}
