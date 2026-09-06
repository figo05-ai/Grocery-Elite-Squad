<?php

namespace App\Filament\Resources\Support\StaticPageResource\Pages;

use App\Filament\Resources\Support\StaticPageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStaticPage extends EditRecord
{
    protected static string $resource = StaticPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
