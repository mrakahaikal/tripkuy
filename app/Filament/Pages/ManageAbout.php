<?php

namespace App\Filament\Pages;

use AboutSettings;
use BackedEnum;
use Filament\Pages\SettingsPage;
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
                //
            ]);
    }
}
