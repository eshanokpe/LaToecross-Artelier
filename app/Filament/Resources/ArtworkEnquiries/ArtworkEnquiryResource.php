<?php

namespace App\Filament\Resources\ArtworkEnquiries;

use App\Filament\Resources\ArtworkEnquiries\Pages\EditArtworkEnquiry;
use App\Filament\Resources\ArtworkEnquiries\Pages\ListArtworkEnquiries;
use App\Filament\Resources\ArtworkEnquiries\Pages\ViewArtworkEnquiry;
use App\Filament\Resources\ArtworkEnquiries\Schemas\ArtworkEnquiryForm;
use App\Filament\Resources\ArtworkEnquiries\Schemas\ArtworkEnquiryInfolist;
use App\Filament\Resources\ArtworkEnquiries\Tables\ArtworkEnquiriesTable;
use App\Models\ArtworkEnquiry;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ArtworkEnquiryResource extends Resource
{
    protected static ?string $model = ArtworkEnquiry::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftEllipsis;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationLabel = 'Artwork Enquiries';
 
    protected static ?string $modelLabel = 'Artwork Enquiry';

    protected static ?string $pluralModelLabel = 'Artwork Enquiries';

    protected static string|UnitEnum|null $navigationGroup = 'Management';

    protected static ?int $navigationSort = 10;

    // ❌ This removes the "Create" button globally
    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return ArtworkEnquiryForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ArtworkEnquiryInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ArtworkEnquiriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListArtworkEnquiries::route('/'),
            // ❌ Removed create route entirely
            'view'  => ViewArtworkEnquiry::route('/{record}'),
            'edit'  => EditArtworkEnquiry::route('/{record}/edit'),
        ];
    }

    public static function getGlobalSearchResultTitle($record): string
    {
        return $record->name . ' - ' . ($record->artwork?->title ?? 'N/A');
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