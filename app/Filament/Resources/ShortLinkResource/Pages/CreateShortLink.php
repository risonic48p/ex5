<?php

namespace App\Filament\Resources\ShortLinkResource\Pages;

use App\Filament\Resources\ShortLinkResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

final class CreateShortLink extends CreateRecord
{
    protected static string $resource = ShortLinkResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        $data['hash'] = md5(microtime());

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
