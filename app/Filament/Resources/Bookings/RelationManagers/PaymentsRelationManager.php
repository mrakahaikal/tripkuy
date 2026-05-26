<?php

namespace App\Filament\Resources\Bookings\RelationManagers;

use App\Mail\BookingConfirmedEmail;
use App\Mail\PaymentRejectedEmail;
use App\Models\Payment;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Support\Facades\Mail;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class PaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('amount')
                    ->label('Jumlah Bayar')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                TextInput::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->placeholder('Transfer BCA'),
                DateTimePicker::make('paid_at')
                    ->label('Waktu Transfer')
                    ->native(false),
                FileUpload::make('proof_image')
                    ->label('Bukti Pembayaran')
                    ->image()
                    ->directory('payments/proofs')
                    ->required()
                    ->columnSpanFull(),
                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'verified' => 'Verified',
                        'rejected' => 'Rejected',
                    ])
                    ->required()
                    ->default('pending'),
                Textarea::make('notes')
                    ->label('Catatan Admin')
                    ->placeholder('Alasan penolakan atau catatan verifikasi...')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('payment_method')
            ->columns([
                TextColumn::make('amount')
                    ->label('Jumlah')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('payment_method')
                    ->label('Metode')
                    ->placeholder('-'),
                ImageColumn::make('proof_image')
                    ->label('Bukti')
                    ->square(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'verified' => 'success',
                        'rejected' => 'danger',
                    }),
                TextColumn::make('paid_at')
                    ->label('Waktu Transfer')
                    ->dateTime('d M Y H:i')
                    ->placeholder('-'),
                TextColumn::make('verified_at')
                    ->label('Diverifikasi')
                    ->dateTime('d M Y H:i')
                    ->placeholder('-'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'verified' => 'Verified',
                        'rejected' => 'Rejected',
                    ]),
            ])
            ->recordActions([
                Action::make('approve')
                    ->label('Setujui')
                    ->icon('lucide-check-circle')
                    ->color('success')
                    ->visible(fn (Payment $record) => $record->status === 'pending')
                    ->modalHeading('Setujui Pembayaran')
                    ->modalSubmitActionLabel('Ya, Setujui')
                    ->infolist([
                        Grid::make(2)->schema([
                            TextEntry::make('amount')
                                ->label('Jumlah Transfer')
                                ->money('IDR'),
                            TextEntry::make('payment_method')
                                ->label('Metode')
                                ->placeholder('-'),
                            TextEntry::make('paid_at')
                                ->label('Waktu Transfer')
                                ->dateTime('d M Y H:i')
                                ->placeholder('-'),
                        ]),
                        ImageEntry::make('proof_image')
                            ->label('Bukti Transfer')
                            ->disk('public')
                            ->height(320)
                            ->columnSpanFull(),
                    ])
                    ->action(function (Payment $record): void {
                        DB::transaction(function () use ($record): void {
                            $record->update([
                                'status'      => 'verified',
                                'verified_at' => now(),
                                'verified_by' => auth()->id(),
                            ]);
                            $record->booking->update([
                                'status'       => 'confirmed',
                                'confirmed_at' => now(),
                            ]);
                        });

                        Mail::to($record->booking->user)->send(new BookingConfirmedEmail($record->booking));

                        Notification::make()
                            ->title('Pembayaran disetujui')
                            ->body('Booking telah dikonfirmasi.')
                            ->success()
                            ->send();
                    }),

                Action::make('reject')
                    ->label('Tolak')
                    ->icon('lucide-x-circle')
                    ->color('danger')
                    ->visible(fn (Payment $record) => $record->status === 'pending')
                    ->modalHeading('Tolak Pembayaran')
                    ->modalSubmitActionLabel('Tolak Pembayaran')
                    ->infolist([
                        Grid::make(2)->schema([
                            TextEntry::make('amount')
                                ->label('Jumlah Transfer')
                                ->money('IDR'),
                            TextEntry::make('payment_method')
                                ->label('Metode')
                                ->placeholder('-'),
                        ]),
                        ImageEntry::make('proof_image')
                            ->label('Bukti Transfer')
                            ->disk('public')
                            ->height(240)
                            ->columnSpanFull(),
                    ])
                    ->schema([
                        Textarea::make('notes')
                            ->label('Alasan Penolakan')
                            ->placeholder('mis. Jumlah transfer tidak sesuai dengan total tagihan.')
                            ->required()
                            ->rows(3),
                    ])
                    ->action(function (Payment $record, array $data): void {
                        $record->update([
                            'status' => 'rejected',
                            'notes'  => $data['notes'],
                        ]);

                        Mail::to($record->booking->user)->send(new PaymentRejectedEmail($record->booking, $data['notes']));

                        Notification::make()
                            ->title('Pembayaran ditolak')
                            ->body('Notifikasi alasan telah disimpan.')
                            ->warning()
                            ->send();
                    }),

                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
