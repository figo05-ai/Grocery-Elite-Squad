<?php

namespace App\Filament\Resources\System\NotificationResource\Pages;

use App\Filament\Resources\System\NotificationResource;
use Filament\Resources\Pages\ListRecords;

class ListNotifications extends ListRecords
{
    protected static string $resource = NotificationResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
