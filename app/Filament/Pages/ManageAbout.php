<?php

namespace App\Filament\Pages;

use App\Settings\AboutSettings;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageAbout extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string $settings = AboutSettings::class;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Tentang TripKuy')
                    ->schema([
                        Repeater::make('team')
                        ->schema([
                            TextInput::make('name')
                                ->label('Nama Tim')
                                ->required(),
                            TextInput::make('nim')
                                ->label('Nomor Induk Mahasiswa')
                                ->required(),
                            FileUpload::make('avatar')
                                ->label('Avatar')
                                ->disk('public')
                                ->visibility('public')
                        ])
                    ])
            ]);
    }
}
