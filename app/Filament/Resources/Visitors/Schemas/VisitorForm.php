<?php

namespace App\Filament\Resources\Visitors\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;

class VisitorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('ip_address')
                    ->label('IP Address')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
            ]);
    }
}
