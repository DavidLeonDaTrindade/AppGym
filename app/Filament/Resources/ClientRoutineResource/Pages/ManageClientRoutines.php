<?php

namespace App\Filament\Resources\ClientRoutineResource\Pages;

use App\Filament\Resources\ClientRoutineResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageClientRoutines extends ManageRecords
{
    protected static string $resource = ClientRoutineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
