<?php

namespace App\Filament\Resources\FashionEnquiries\Pages;

use App\Filament\Resources\FashionEnquiries\FashionEnquiryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFashionEnquiries extends ListRecords
{
    protected static string $resource = FashionEnquiryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
