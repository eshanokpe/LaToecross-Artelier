<?php

namespace App\Filament\Resources\Artworks;

use App\Filament\Resources\Artworks\Pages\CreateArtwork;
use App\Filament\Resources\Artworks\Pages\EditArtwork;
use App\Filament\Resources\Artworks\Pages\ListArtworks;
use App\Filament\Resources\Artworks\Schemas\ArtworkForm;
use App\Filament\Resources\Artworks\Tables\ArtworksTable;
use App\Models\Artwork;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ArtworkResource extends Resource
{
    protected static ?string $model = Artwork::class;
    protected static ?string $recordTitleAttribute = 'title'; // ✅ ADD THIS LINE
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationLabel = 'Artworks';
    protected static ?string $pluralLabel = 'Artworks';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return ArtworkForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ArtworksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListArtworks::route('/'),
            'create' => CreateArtwork::route('/create'),
            'edit' => EditArtwork::route('/{record}/edit'),
        ];
    }
}
