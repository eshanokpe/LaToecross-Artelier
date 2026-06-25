<?php

namespace App\Filament\Resources\Sliders\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SliderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('button_text')
                    ->maxLength(50)
                    ->default(null),
                TextInput::make('button_url')
                    ->maxLength(50)
                    ->default(null),
                FileUpload::make('image')
                    ->image()
                    ->directory('sliders')
                    ->required(),
                TextInput::make('sort_order')
                    ->required()
                    ->default(0)
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->default(true)
                    ->required(),
            ]);
    }
}
