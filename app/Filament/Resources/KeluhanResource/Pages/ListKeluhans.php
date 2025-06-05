<?php

namespace App\Filament\Resources\KeluhanResource\Pages;

use App\Filament\Resources\KeluhanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKeluhans extends ListRecords
{
    protected static string $resource = KeluhanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
