<?php

namespace App\Filament\Resources\ArtworkEnquiries\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Action;
use Filament\Notifications\Notification;

class ArtworkEnquiriesTable
{
    protected static ?string $model = ArtworkEnquiry::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationGroup = 'Art Management';
    protected static ?int $navigationSort = 10;

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('index')
                    ->label('#')
                    ->getStateUsing(function ($rowLoop) {
                        return $rowLoop->index + 1;
                    })
                    ->sortable(false)
                    ->toggleable(false)
                    ->width(50)
                    ->alignCenter()
                    ->extraAttributes([
                        'style' => 'font-weight: bold; color: #6b3b4f;'
                    ]),
                TextColumn::make('artwork.title')
                    ->label('Artwork')
                    ->sortable()
                    ->searchable()
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->artwork->title ?? 'N/A'),
                
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->icon('heroicon-o-envelope')
                    ->copyable()
                    ->copyMessage('Email copied!'),
                TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable()
                    ->toggleable()
                    ->placeholder('Not provided'),
                BadgeColumn::make('is_read')
                    ->label('Status')
                    ->colors([
                        'danger' => false,
                        'success' => true,
                    ])
                    ->formatStateUsing(fn ($state) => $state ? 'Read' : 'Unread'),
                TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable()
                    ->since()
                    ->tooltip(fn ($record) => $record->created_at->format('F j, Y \a\t g:i A')),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('is_read')
                    ->label('Status')
                    ->options([
                        '0' => 'Unread',
                        '1' => 'Read',
                    ]),
                
                SelectFilter::make('artwork_id')
                    ->label('Artwork')
                    ->relationship('artwork', 'title')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                ViewAction::make()
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->color('info'),
                
                EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->color('warning'),
                
               
                
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
