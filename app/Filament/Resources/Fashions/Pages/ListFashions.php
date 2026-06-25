<?php

namespace App\Filament\Resources\Fashions\Pages;

use App\Filament\Resources\Fashions\FashionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFashions extends ListRecords
{
    protected static string $resource = FashionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
