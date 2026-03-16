<?php

namespace App\Filament\Resources\DietResource\Pages;

use App\Filament\Resources\DietResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDiets extends ManageRecords
{
    protected static string $resource = DietResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
