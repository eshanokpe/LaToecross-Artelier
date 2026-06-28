<?php

namespace App\Filament\Resources\FashionEnquiries\Pages;

use App\Filament\Resources\FashionEnquiries\FashionEnquiryResource;
use Filament\Actions;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Notifications\Notification;

class ViewFashionEnquiry extends ViewRecord
{
    protected static string $resource = FashionEnquiryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // EditAction::make()
            //     ->label('Edit')
            //     ->icon('heroicon-o-pencil-square'),

            Actions\Action::make('mark_read')
                ->label('Mark as Read')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->action(function ($record) {
                    $record->markAsRead();
                    Notification::make()
                        ->title('Enquiry marked as read')
                        ->success()
                        ->send();
                })
                ->visible(fn ($record) => !$record->is_read),

            Actions\Action::make('reply')
                ->label('Reply via Email')
                // ✅ Fixed icon name — use one of these valid Heroicons
                ->icon('heroicon-o-arrow-uturn-left')
                // Alternative option: ->icon('heroicon-o-paper-airplane')
                ->color('primary')
                ->url(fn ($record) => "mailto:{$record->email}?subject=Re: Fashion Enquiry - {$record->fashion?->title}")
                ->openUrlInNewTab(),
            Actions\DeleteAction::make()
                ->label('Delete')
                ->icon('heroicon-o-trash')
                ->color('danger'),
        ];
    }
}