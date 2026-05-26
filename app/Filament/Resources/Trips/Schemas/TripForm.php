<?php

namespace App\Filament\Resources\Trips\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Set;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class TripForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Wizard\Step::make('Informasi Dasar')
                        ->description('Judul, kategori, dan status publikasi trip.')
                        ->icon('lucide-info')
                        ->schema([
                            Select::make('category_id')
                                ->label('Kategori')
                                ->relationship('category', 'name')
                                ->searchable()
                                ->preload()
                                ->helperText('Pilih kategori yang sesuai, mis. Petualangan Alam, Wisata Budaya.')
                                ->required(),
                            Select::make('status')
                                ->label('Status')
                                ->options([
                                    'draft'     => 'Draft',
                                    'published' => 'Published',
                                    'full'      => 'Full',
                                    'cancelled' => 'Cancelled',
                                    'completed' => 'Completed',
                                ])
                                ->helperText('Draft tidak tampil ke publik. Published langsung bisa dipesan.')
                                ->required()
                                ->default('draft'),
                            Select::make('difficulty_level')
                                ->label('Tingkat Kesulitan')
                                ->options([
                                    'easy'     => 'Easy — Cocok untuk semua usia',
                                    'moderate' => 'Moderate — Butuh stamina dasar',
                                    'hard'     => 'Hard — Untuk peserta berpengalaman',
                                ])
                                ->helperText('Membantu calon peserta menilai kesesuaian trip.')
                                ->required()
                                ->default('moderate'),
                            TextInput::make('title')
                                ->label('Judul Trip')
                                ->placeholder('mis. Pendakian Rinjani 3 Hari 2 Malam')
                                ->helperText('Judul singkat dan menarik yang menggambarkan trip ini.')
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug((string) $state)))
                                ->columnSpanFull(),
                            TextInput::make('slug')
                                ->placeholder('pendakian-rinjani-3-hari-2-malam')
                                ->helperText('Dibuat otomatis dari judul. Digunakan sebagai URL halaman trip.')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->columnSpanFull(),
                        ])
                        ->columns(3),

                    Wizard\Step::make('Lokasi & Jadwal')
                        ->description('Destinasi, titik keberangkatan, dan waktu pelaksanaan.')
                        ->icon('lucide-map-pin')
                        ->schema([
                            TextInput::make('destination')
                                ->label('Destinasi')
                                ->placeholder('mis. Gunung Rinjani, Lombok')
                                ->helperText('Lokasi utama tujuan trip.')
                                ->required(),
                            TextInput::make('departure_city')
                                ->label('Kota Keberangkatan')
                                ->placeholder('mis. Mataram, Lombok')
                                ->helperText('Kota atau titik awal peserta berkumpul.')
                                ->required(),
                            TextInput::make('meeting_point')
                                ->label('Meeting Point')
                                ->placeholder('mis. Terminal Mandalika pukul 07.00 WITA')
                                ->helperText('Opsional. Lokasi spesifik tempat peserta berkumpul.')
                                ->columnSpanFull(),
                            Grid::make(3)
                                ->schema([
                                    DatePicker::make('start_date')
                                        ->label('Tanggal Berangkat')
                                        ->placeholder('Pilih tanggal...')
                                        ->helperText('Hari pertama keberangkatan trip.')
                                        ->required()
                                        ->native(false),
                                    DatePicker::make('end_date')
                                        ->label('Tanggal Kembali')
                                        ->placeholder('Pilih tanggal...')
                                        ->helperText('Hari terakhir / kepulangan peserta.')
                                        ->required()
                                        ->native(false)
                                        ->after('start_date'),
                                    TextInput::make('duration_days')
                                        ->label('Durasi')
                                        ->placeholder('mis. 3')
                                        ->helperText('Total hari pelaksanaan trip.')
                                        ->required()
                                        ->numeric()
                                        ->minValue(1)
                                        ->suffix('hari'),
                                ])
                                ->columnSpanFull(),
                        ])
                        ->columns(2),

                    Wizard\Step::make('Harga & Kuota')
                        ->description('Penetapan harga, batas peserta, dan minimum keberangkatan.')
                        ->icon('lucide-circle-dollar-sign')
                        ->schema([
                            TextInput::make('price')
                                ->label('Harga per Orang')
                                ->placeholder('mis. 1500000')
                                ->helperText('Harga yang dikenakan per peserta. Belum termasuk biaya tambahan.')
                                ->required()
                                ->numeric()
                                ->prefix('Rp')
                                ->minValue(0),
                            TextInput::make('quota')
                                ->label('Kuota Maksimal')
                                ->placeholder('mis. 15')
                                ->helperText('Batas maksimum peserta yang bisa mendaftar.')
                                ->required()
                                ->numeric()
                                ->minValue(1)
                                ->suffix('orang'),
                            TextInput::make('min_participants')
                                ->label('Minimum Peserta')
                                ->placeholder('mis. 5')
                                ->helperText('Trip hanya akan berangkat jika peserta mencapai angka ini.')
                                ->required()
                                ->numeric()
                                ->minValue(1)
                                ->default(1)
                                ->suffix('orang'),
                        ])
                        ->columns(3),

                    Wizard\Step::make('Deskripsi & Media')
                        ->description('Tagline, deskripsi lengkap, gambar cover, serta fasilitas.')
                        ->icon('lucide-image')
                        ->schema([
                            TextInput::make('highlight')
                                ->label('Highlight')
                                ->placeholder('mis. Saksikan sunrise di atas awan bersama guide berpengalaman')
                                ->helperText('Tagline singkat (maks. 160 karakter) yang tampil di kartu trip.')
                                ->maxLength(160)
                                ->columnSpanFull(),
                            Textarea::make('description')
                                ->label('Deskripsi Lengkap')
                                ->placeholder('Ceritakan detail perjalanan, pengalaman yang akan didapat, apa saja yang akan dikunjungi...')
                                ->helperText('Deskripsi panjang yang tampil di halaman detail trip.')
                                ->required()
                                ->rows(5)
                                ->columnSpanFull(),
                            FileUpload::make('cover_image')
                                ->label('Gambar Cover')
                                ->helperText('Disarankan ukuran 1200×800 px. Format JPG/PNG, maks. 2 MB.')
                                ->image()
                                ->imageEditor()
                                ->directory('trips/covers')
                                ->columnSpanFull(),
                            TagsInput::make('includes')
                                ->label('Sudah Termasuk')
                                ->placeholder('Tambah item, lalu Enter...')
                                ->helperText('mis. Tiket masuk, makan 3x sehari, porter, guide bersertifikat.')
                                ->columnSpanFull(),
                            TagsInput::make('excludes')
                                ->label('Belum Termasuk')
                                ->placeholder('Tambah item, lalu Enter...')
                                ->helperText('mis. Transportasi dari kota asal, penginapan sebelum keberangkatan.')
                                ->columnSpanFull(),
                        ]),
                ])
                ->columnSpanFull(),
            ]);
    }
}
