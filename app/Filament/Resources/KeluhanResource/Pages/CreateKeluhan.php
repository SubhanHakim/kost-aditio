<?php

namespace App\Filament\Resources\KeluhanResource\Pages;

use App\Filament\Resources\KeluhanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKeluhan extends CreateRecord
{
    protected static string $resource = KeluhanResource::class;

    public static function canAccessPage(): bool
    {
        return false;
    }
}