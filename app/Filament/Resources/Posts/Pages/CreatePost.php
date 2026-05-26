<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    protected ?string $heading = 'Tulis Artikel Baru';

    protected ?string $subheading = 'Buat konten blog perjalanan untuk dipublikasikan.';
}
