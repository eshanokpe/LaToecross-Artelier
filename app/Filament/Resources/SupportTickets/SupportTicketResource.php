<?php

namespace App\Filament\Resources\SupportTickets;

use App\Filament\Resources\SupportTickets\Pages\CreateSupportTicket;
use App\Filament\Resources\SupportTickets\Pages\EditSupportTicket;
use App\Filament\Resources\SupportTickets\Pages\ListSupportTickets;
use App\Filament\Resources\SupportTickets\Pages\ViewSupportTicket;
use App\Filament\Resources\SupportTickets\Schemas\SupportTicketForm;
use App\Filament\Resources\SupportTickets\Schemas\SupportTicketInfolist;
use App\Filament\Resources\SupportTickets\Tables\SupportTicketsTable;
use App\Models\SupportTicket;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum; // ✅ Added required import

class SupportTicketResource extends Resource
{
    protected static ?string $model = SupportTicket::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-ticket';

    // ✅ Fixed: correct type definition
    protected static ?string $recordTitleAttribute = 'subject';

    // ✅ EXACT TYPE MATCH required by Filament
    protected static string|UnitEnum|null $navigationGroup = 'Support Management';

    // Optional: add these for better display
    protected static ?string $navigationLabel = 'Support Tickets';
    protected static ?string $modelLabel = 'Support Ticket';
    protected static ?string $pluralModelLabel = 'Support Tickets';
    protected static ?int $navigationSort = 15;

    public static function form(Schema $schema): Schema
    {
        return SupportTicketForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SupportTicketInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SupportTicketsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListSupportTickets::route('/'),
            'create' => CreateSupportTicket::route('/create'),
            'view'   => ViewSupportTicket::route('/{record}'),
            'edit'   => EditSupportTicket::route('/{record}/edit'),
        ];
    }

     public static function getGlobalSearchResultTitle($record): string
    {
        return $record->name . ' - ' . ($record->supportticket?->title ?? 'N/A');
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