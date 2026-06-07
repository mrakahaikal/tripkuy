<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class AboutSettings extends Settings
{
    public array $team;

    public static function group(): string
    {
        return 'about';
    }
}
