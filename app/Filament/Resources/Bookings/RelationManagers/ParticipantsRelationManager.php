<?php

namespace App\Filament\Resources\Bookings\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ParticipantsRelationManager extends RelationManager
{
    protected static string $relationship = 'participants';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required(),
                TextInput::make('id_number')
                    ->label('No. KTP / Paspor')
                    ->required(),
                DatePicker::make('date_of_birth')
                    ->label('Tanggal Lahir')
                    ->required()
                    ->native(false)
                    ->maxDate(now()->subYears(17)),
                Select::make('gender')
                    ->label('Jenis Kelamin')
                    ->options([
                        'male' => 'Laki-laki',
                        'female' => 'Perempuan',
                    ])
                    ->required(),
                TextInput::make('phone')
                    ->label('No. HP')
                    ->tel(),
                TextInput::make('emergency_contact_name')
                    ->label('Kontak Darurat'),
                TextInput::make('emergency_contact_phone')
                    ->label('HP Kontak Darurat')
                    ->tel(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                TextColumn::make('id_number')
                    ->label('No. KTP')
                    ->searchable(),
                TextColumn::make('date_of_birth')
                    ->label('Tgl. Lahir')
                    ->date('d M Y'),
                TextColumn::make('gender')
                    ->label('Kelamin')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => $state === 'male' ? 'Laki-laki' : 'Perempuan')
                    ->color(fn (string $state) => $state === 'male' ? 'info' : 'pink'),
                TextColumn::make('phone')
                    ->label('No. HP')
                    ->placeholder('-'),
            ])
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
