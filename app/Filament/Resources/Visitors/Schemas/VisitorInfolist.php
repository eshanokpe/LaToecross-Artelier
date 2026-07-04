<?php

namespace App\Filament\Resources\Visitors\Schemas;

use Filament\Schemas\Schema;
use Filament\Infolists\Components\TextEntry;

class VisitorInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('ip_address')
                    ->label('IP Address')
                    ->copyable()
                    ->copyMessage('IP copied to clipboard'),
                TextEntry::make('created_at')
                    ->label('Visited At')
                    ->dateTime('d M Y • H:i:s'),
                TextEntry::make('country')
                    ->label('Country')
                    ->placeholder('Not detected'),

                TextEntry::make('city')
                    ->label('City')
                    ->placeholder('Not detected'),

                TextEntry::make('device')
                    ->label('Device'),
                
                TextEntry::make('browser')
                    ->label('Browser'),

                TextEntry::make('page_url')
                    ->label('Page Visited')
                    ->columnSpanFull()
                    ->url(fn ($record) => $record->page_url, true),

                TextEntry::make('user_agent')
                    ->label('User Agent')
                    ->columnSpanFull()
                    ->limit(120)
                    ->tooltip(fn ($record) => $record->user_agent),
            ]);
    }
}
