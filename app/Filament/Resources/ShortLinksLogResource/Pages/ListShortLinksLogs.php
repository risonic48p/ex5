<?php

namespace App\Filament\Resources\ShortLinksLogResource\Pages;

use App\Filament\Resources\ShortLinksLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListShortLinksLogs extends ListRecords
{
    protected static string $resource = ShortLinksLogResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
