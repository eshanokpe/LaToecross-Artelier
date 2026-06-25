<?php

namespace App\Filament\Resources\Settings\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->label('Setting Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('value')
                    ->label('Current Content')
                    ->limit(80)
                    ->wrap(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->bulkActions([
                // Remove delete option to protect settings
            ]);
    } 
}