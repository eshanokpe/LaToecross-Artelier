<?php

namespace App\Filament\Resources\ContactMessages\Schemas;

use Filament\Schemas\Components\TextEntry;
use Filament\Schemas\Components\IconEntry;
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

                IconEntry::make('is_read')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-exclamation-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->trueLabel('Read')
                    ->falseLabel('Unread'),

                TextEntry::make('created_at')
                    ->label('Received On')
                    ->dateTime('d M Y • H:i A'),
            ]);
    }
}