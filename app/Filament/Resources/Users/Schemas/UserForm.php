<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Informasi Pribadi')
                    ->description('Data identitas pengguna yang ditampilkan di profil.')
                    ->icon('lucide-user')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->placeholder('mis. Budi Santoso')
                            ->helperText('Nama yang akan ditampilkan di profil dan booking.')
                            ->required(),
                        TextInput::make('email')
                            ->label('Alamat Email')
                            ->placeholder('budi@email.com')
                            ->helperText('Digunakan untuk login dan notifikasi.')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true),
                        TextInput::make('phone')
                            ->label('Nomor Telepon')
                            ->placeholder('08xxxxxxxxxx')
                            ->helperText('Nomor yang dapat dihubungi via WhatsApp/SMS.')
                            ->tel()
                            ->nullable(),
                        FileUpload::make('avatar')
                            ->label('Foto Profil')
                            ->helperText('Format JPG/PNG, ukuran maks. 2 MB.')
                            ->image()
                            ->directory('avatars')
                            ->nullable()
                            ->columnSpanFull(),
                    ]),

                Section::make('Akses & Keamanan')
                    ->description('Atur role dan password untuk menentukan hak akses pengguna.')
                    ->icon('lucide-shield')
                    ->columns(2)
                    ->schema([
                        Select::make('role')
                            ->label('Role')
                            ->options([
                                'user'  => 'User',
                                'admin' => 'Admin',
                            ])
                            ->helperText('Admin memiliki akses penuh ke panel manajemen.')
                            ->required()
                            ->default('user'),
                        TextInput::make('password')
                            ->label('Password')
                            ->placeholder('Kosongkan jika tidak ingin mengubah password')
                            ->helperText('Min. 8 karakter. Kosongkan untuk mempertahankan password lama.')
                            ->password()
                            ->required(fn ($record) => $record === null)
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                            ->dehydrated(fn ($state) => filled($state)),
                    ]),
            ]);
    }
}
