<?php

namespace App\Filament\Resources\ContactMessages\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ContactMessageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Name'),
                TextEntry::make('email')
                    ->label('Email')
                    ->copyable(),
                TextEntry::make('subject')
                    ->label('Subject'),
                TextEntry::make('message')
                    ->label('Message')
                    ->markdown()
                    ->columnSpanFull(),
                TextEntry::make('is_read')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Read' : 'Unread')
                    ->color(fn (bool $state): string => $state ? 'success' : 'danger'),
                TextEntry::make('created_at')
                    ->label('Received On')
                    ->dateTime('d M Y • H:i A'),
            ]);
    }
}