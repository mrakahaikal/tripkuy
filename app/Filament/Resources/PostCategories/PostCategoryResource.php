<?php

namespace App\Filament\Resources\PostCategories;

use App\Filament\Resources\PostCategories\Pages\ManagePostCategories;
use App\Models\PostCategory;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PostCategoryResource extends Resource
{
    protected static ?string $model = PostCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFolderOpen;

    protected static ?string $navigationLabel = 'Kategori Artikel';

    protected static string|\UnitEnum|null $navigationGroup = 'Konten';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Identitas Kategori')
                    ->description('Informasi dasar yang mengidentifikasi kategori artikel di blog.')
                    ->icon('lucide-folder-open')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Kategori')
                            ->placeholder('mis. Tips Traveling')
                            ->helperText('Nama yang akan ditampilkan sebagai label kategori.')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug((string) $state))),
                        TextInput::make('slug')
                            ->placeholder('tips-traveling')
                            ->helperText('Dibuat otomatis dari nama, digunakan di URL artikel.')
                            ->required()
                            ->unique(ignoreRecord: true),
                        TextInput::make('description')
                            ->label('Deskripsi')
                            ->placeholder('Ceritakan secara singkat isi kategori ini...')
                            ->helperText('Opsional. Ditampilkan di halaman daftar kategori.')
                            ->nullable()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->placeholder('-')
                    ->limit(60),
                TextColumn::make('posts_count')
                    ->label('Jumlah Post')
                    ->counts('posts')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManagePostCategories::route('/'),
        ];
    }
}
