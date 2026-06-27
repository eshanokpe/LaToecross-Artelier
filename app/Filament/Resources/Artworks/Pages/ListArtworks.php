<?php

namespace App\Filament\Resources\Artworks\Pages;

use App\Filament\Resources\Artworks\ArtworkResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;

class ListArtworks extends ListRecords
{
    protected static string $resource = ArtworkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('s_n')
                    ->label('S/N')
                    ->rowIndex(),
                ImageColumn::make('image')
                    ->label('Artwork')
                    ->disk('public')          // ← CRITICAL: Use public disk
                    ->height(80)
                    ->width(80)
                    // ->rounded()
                    ->square()
                    ->getStateUsing(fn ($record) => $record->image ?: null)
                    ->defaultImageUrl(fn ($record) => $record->image 
                        ? asset('storage/' . $record->image) 
                        : asset('images/placeholder.jpg')
                    ),
                
                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                
                TextColumn::make('style')
                ->label('Category')
                ->badge()
                ->formatStateUsing(fn (string $state): string => match ($state) {
                    'abstract' => 'Abstract Painting',
                    'landscape' => 'Landscape Painting',
                    'mixed_media' => 'Mixed Media Painting',
                    'figure' => 'Figure Painting',
                    'miniature' => 'Miniature',
                    default => ucfirst($state),
                })
                ->color(fn (string $state): string => match ($state) {
                    'abstract' => 'danger',
                    'landscape' => 'success',
                    'mixed_media' => 'warning',
                    'figure' => 'info',
                    'miniature' => 'primary',
                    default => 'gray',
                }),
                
                TextColumn::make('medium')
                    ->label('Medium')
                    ->limit(30)
                    ->toggleable(),
                
                TextColumn::make('dimensions')
                    ->label('Dimensions')
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('price')
                    ->label('Price (₦)')
                    ->money('NGN')
                    ->sortable()
                    ->color(fn ($state) => $state ? 'success' : 'gray'),
                
                ToggleColumn::make('is_for_sale')
                    ->label('For Sale'),
                
                ToggleColumn::make('is_featured')
                    ->label('Featured')
                    ->onColor('warning')
                    ->offColor('gray'),
                
                TextColumn::make('created_at')
                    ->label('Created')
                    ->date('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Your actions here
            ])
            ->bulkActions([
                // Your bulk actions here
            ]);
    }
}