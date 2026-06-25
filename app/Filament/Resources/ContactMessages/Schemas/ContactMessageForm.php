<?php

namespace App\Filament\Resources\ContactMessages\Schemas;

use Filament\Schemas\Components\TextInput;
use Filament\Schemas\Components\Textarea;
use Filament\Schemas\Components\Toggle;
use Filament\Schemas\Schema;

class ContactMessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Sender Name')
                    ->disabled()
                    ->columnSpanFull(),

                TextInput::make('email')
                    ->label('Email Address')
                    ->disabled()
                    ->columnSpanFull(),

                TextInput::make('subject')
                    ->label('Subject')
                    ->disabled()
                    ->columnSpanFull(),

                Textarea::make('message')
                    ->label('Message')
                    ->rows(6)
                    ->disabled()
                    ->columnSpanFull(),

                Toggle::make('is_read')
                    ->label('Mark as Read')
                    ->helperText('Toggle to mark this message as read or unread')
                    ->columnSpanFull(),
            ]);
    }
}