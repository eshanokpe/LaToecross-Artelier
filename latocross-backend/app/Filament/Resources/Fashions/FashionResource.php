<?php

namespace App\Filament\Resources\Fashions;

use App\Filament\Resources\Fashions\Pages\CreateFashion;
use App\Filament\Resources\Fashions\Pages\EditFashion;
use App\Filament\Resources\Fashions\Pages\ListFashions;
use App\Filament\Resources\Fashions\Schemas\FashionForm;
use App\Filament\Resources\Fashions\Tables\FashionsTable;
use App\Models\Fashion;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FashionResource extends Resource
{
    protected static ?string $model = Fashion::class;
    protected static ?string $recordTitleAttribute = 'title';
    
    // ✅ EXACT type Filament requires: BackedEnum|string|null
    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedScissors;
    
    protected static ?string $navigationLabel = 'Fashion & Wearable Art';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return FashionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FashionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFashions::route('/'),
            'create' => CreateFashion::route('/create'),
            'edit' => EditFashion::route('/{record}/edit'),
        ];
    }
}