<?php

namespace App\Filament\Resources\Fashions\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class FashionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Piece Title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Select::make('category')
                    ->label('Category')
                    ->options([
                        'wearable_art' => 'Wearable Art',
                        'dress' => 'Dress',
                        'accessory' => 'Accessory',
                        'textile' => 'Textile Art',
                    ])
                    ->required()
                    ->columnSpanFull(),

                TextInput::make('fabric')
                    ->label('Fabric / Material')
                    ->maxLength(255)
                    ->placeholder('e.g. Hand-dyed cotton, Silk, Adire, Mixed fabric'),

                TextInput::make('dimensions')
                    ->label('Dimensions / Size')
                    ->maxLength(255)
                    ->placeholder('e.g. Size M, Length 140cm × Width 55cm'),

                TextInput::make('price')
                    ->label('Price (₦)')
                    ->numeric()
                    ->prefix('₦')
                    ->maxValue(99999999.99),

                Toggle::make('is_for_sale')
                    ->label('Available for Sale'),

                Toggle::make('is_featured')
                    ->label('Feature on Homepage'),

                Textarea::make('description')
                    ->label('Description & Story')
                    ->rows(5)
                    ->placeholder('Tell about the design, inspiration, and process...')
                    ->columnSpanFull(),

                FileUpload::make('image')
                    ->label('Piece Image')
                    ->image()
                    ->directory('fashion')
                    ->visibility('public')
                    ->required()
                    ->imageResizeMode('cover')
                    ->imagePreviewHeight('250')
                    ->columnSpanFull(),
            ]);
    }
}