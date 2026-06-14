<?php

namespace App\Filament\Resources\Artworks\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ArtworkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Select::make('style')
                    ->label('Art Style')
                    ->options([
                        'realism' => 'Realism',
                        'impressionism' => 'Impressionism',
                        'abstract' => 'Abstract',
                        'mixed_media' => 'Mixed Media',
                    ])
                    ->required()
                    ->columnSpanFull(),

                TextInput::make('medium')
                    ->label('Medium')
                    ->placeholder('e.g. Oil on canvas, Acrylic, Mixed Media')
                    ->maxLength(255),

                TextInput::make('dimensions')
                    ->label('Dimensions')
                    ->placeholder('e.g. 60cm × 80cm')
                    ->maxLength(255),

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
                    ->label('Description')
                    ->rows(5)
                    ->placeholder('Tell the story behind this piece...')
                    ->columnSpanFull(),

                FileUpload::make('image')
                    ->label('Artwork Image')
                    ->image()
                    ->directory('artworks')
                    ->visibility('public')
                    ->required()
                    ->imageResizeMode('cover')
                    ->imagePreviewHeight('250')
                    ->columnSpanFull(),
            ]);
    }
}