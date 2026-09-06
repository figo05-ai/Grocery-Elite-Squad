<?php

namespace App\Filament\Resources\Catalog\SubcategoryResource\Pages;

use App\Filament\Resources\Catalog\SubcategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubcategory extends EditRecord
{
    protected static string $resource = SubcategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
