<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Meta Artikel')
                    ->description('Pengaturan kategori, penulis, dan status publikasi artikel.')
                    ->icon('lucide-settings')
                    ->columns(2)
                    ->schema([
                        Select::make('post_category_id')
                            ->label('Kategori')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->helperText('Pilih kategori yang paling sesuai dengan topik artikel.')
                            ->required(),
                        Select::make('user_id')
                            ->label('Penulis')
                            ->relationship('author', 'name')
                            ->searchable()
                            ->preload()
                            ->helperText('Nama penulis yang akan ditampilkan di artikel.')
                            ->required(),
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'draft'     => 'Draft',
                                'published' => 'Published',
                                'archived'  => 'Archived',
                            ])
                            ->helperText('Draft tidak tampil ke publik. Published langsung aktif.')
                            ->required()
                            ->default('draft')
                            ->live()
                            ->columnSpanFull(),
                        DateTimePicker::make('published_at')
                            ->label('Tanggal Publish')
                            ->placeholder('Pilih tanggal & waktu...')
                            ->helperText('Waktu artikel mulai tampil di halaman publik.')
                            ->native(false)
                            ->visible(fn ($get) => $get('status') === 'published')
                            ->columnSpanFull(),
                    ]),

                Section::make('Konten Artikel')
                    ->description('Judul, ringkasan, dan gambar cover yang mewakili artikel.')
                    ->icon('lucide-file-text')
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul')
                            ->placeholder('mis. 10 Destinasi Wisata Terbaik di Lombok')
                            ->helperText('Judul menarik yang menggambarkan isi artikel (maks. 160 karakter).')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug((string) $state)))
                            ->columnSpanFull(),
                        TextInput::make('slug')
                            ->placeholder('10-destinasi-wisata-terbaik-di-lombok')
                            ->helperText('Dibuat otomatis dari judul. Digunakan sebagai URL artikel.')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->columnSpanFull(),
                        Textarea::make('excerpt')
                            ->label('Ringkasan')
                            ->maxLength(300)
                            ->rows(3)
                            ->placeholder('Deskripsi singkat untuk preview artikel di halaman daftar...')
                            ->helperText('Maks. 300 karakter. Ditampilkan di kartu artikel dan meta SEO.')
                            ->columnSpanFull(),
                        FileUpload::make('cover_image')
                            ->label('Gambar Cover')
                            ->helperText('Disarankan ukuran 1200×630 px. Format JPG/PNG, maks. 2 MB.')
                            ->image()
                            ->imageEditor()
                            ->directory('posts/covers')
                            ->columnSpanFull(),
                    ]),

                Section::make('Isi Artikel')
                    ->description('Tulis konten lengkap artikel menggunakan editor teks kaya.')
                    ->icon('lucide-pen-line')
                    ->schema([
                        RichEditor::make('content')
                            ->label('Konten')
                            ->required()
                            ->toolbarButtons([
                                'bold', 'italic', 'underline', 'strike',
                                'h2', 'h3',
                                'bulletList', 'orderedList', 'blockquote',
                                'link', 'codeBlock',
                                'undo', 'redo',
                            ])
                            ->columnSpanFull(),
                    ]),
            ])
            ->columns(1);
    }
}
