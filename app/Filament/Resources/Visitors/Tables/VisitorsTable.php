<?php

namespace App\Filament\Resources\Visitors\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VisitorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                TextColumn::make('country')
                    ->label('Country')
                    ->sortable(),

                TextColumn::make('city')
                    ->label('City')
                    ->sortable(),

                TextColumn::make('page_url')
                    ->label('Page Visited')
                    ->limit(60)
                    ->searchable()
                    ->wrap(),

                TextColumn::make('device')
                    ->label('Device'),

                TextColumn::make('browser')
                    ->label('Browser'),

                TextColumn::make('created_at')
                    ->label('Visited At')
                    ->dateTime('d M Y • H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                // Add filters here later if needed
            ])
            ->actions([
                ViewAction::make(),
                DeleteAction::make(),
                // Removed EditAction — visitor logs should be read-only
            ]) 
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('10s'); // Auto-refresh every 10 seconds
    }
}