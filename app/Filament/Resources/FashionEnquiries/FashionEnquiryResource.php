<?php

namespace App\Filament\Resources\FashionEnquiries;

use App\Filament\Resources\FashionEnquiries\Pages\CreateFashionEnquiry;
use App\Filament\Resources\FashionEnquiries\Pages\EditFashionEnquiry;
use App\Filament\Resources\FashionEnquiries\Pages\ListFashionEnquiries;
use App\Filament\Resources\FashionEnquiries\Pages\ViewFashionEnquiry;
use App\Filament\Resources\FashionEnquiries\Schemas\FashionEnquiryForm;
use App\Filament\Resources\FashionEnquiries\Schemas\FashionEnquiryInfolist;
use App\Filament\Resources\FashionEnquiries\Tables\FashionEnquiriesTable;
use App\Models\FashionEnquiry;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class FashionEnquiryResource extends Resource
{
    protected static ?string $model = FashionEnquiry::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    
    protected static ?string $recordTitleAttribute = 'FashionEnquiry';
    protected static string|UnitEnum|null $navigationGroup = 'Management';

    // ❌ This removes the "Create" button globally
    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return FashionEnquiryForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FashionEnquiryInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FashionEnquiriesTable::configure($table);
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
            'index' => ListFashionEnquiries::route('/'),
            'view' => ViewFashionEnquiry::route('/{record}'),
            'edit' => EditFashionEnquiry::route('/{record}/edit'),
        ];
    }

    public static function getGlobalSearchResultTitle($record): string
    {
        return $record->name . ' - ' . ($record->fashion?->title ?? 'N/A');
    }

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('is_read', false)->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }
}
