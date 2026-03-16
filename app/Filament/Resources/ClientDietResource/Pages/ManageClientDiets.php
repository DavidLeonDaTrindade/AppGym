<?php

namespace App\Filament\Resources\ClientDietResource\Pages;

use App\Filament\Resources\ClientDietResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageClientDiets extends ManageRecords
{
    protected static string $resource = ClientDietResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
