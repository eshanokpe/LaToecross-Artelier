<?php

namespace App\Filament\Resources\Fashions\Pages;

use App\Filament\Resources\Fashions\FashionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFashion extends EditRecord
{
    protected static string $resource = FashionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
