<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class AboutSettings extends Settings
{

    public static function group(): string
    {
        return 'about';
    }
}