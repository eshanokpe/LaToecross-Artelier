<?php

namespace App\Filament\Resources\Artworks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;

class ArtworksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Image')
                    ->size(80),

                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('artist')
                    ->label('Artist')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('medium')
                    ->label('Medium')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('dimensions')
                    ->label('Dimensions')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('price')
                    ->label('Price')
                    ->money('NGN')
                    ->sortable()
                    ->placeholder('Not for sale'),
 
                IconColumn::make('is_for_sale')
                    ->label('For Sale')
                    ->boolean(),

                IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('is_for_sale')
                    ->query(fn ($query) => $query->where('is_for_sale', true))
                    ->label('Only For Sale'),

                Filter::make('is_featured')
                    ->query(fn ($query) => $query->where('is_featured', true))
                    ->label('Only Featured'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}