<?php

namespace App\Filament\Resources\ShortLinkResource\Pages;

use App\Filament\Resources\ShortLinkResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Webbingbrasil\FilamentCopyActions\Pages\Actions\CopyAction;

final class ViewShortLink extends ViewRecord
{
    protected static string $resource = ShortLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CopyAction::make()->copyable(fn ($record) => $record->shortUrl)
                ->label('Скопировать Шортлинк')
                ->successNotificationTitle('Скопированно!'),
            Actions\DeleteAction::make(),
        ];
    }
}
