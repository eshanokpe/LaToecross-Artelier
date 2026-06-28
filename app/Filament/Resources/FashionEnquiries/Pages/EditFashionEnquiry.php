<?php

namespace App\Filament\Resources\FashionEnquiries\Pages;

use App\Filament\Resources\FashionEnquiries\FashionEnquiryResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditFashionEnquiry extends EditRecord
{
    protected static string $resource = FashionEnquiryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()->icon('heroicon-o-eye'),
            DeleteAction::make()
                ->icon('heroicon-o-trash')
                ->color('danger'),
        ];
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Enquiry updated')
            ->body('The enquiry has been updated successfully.');
    }
}
