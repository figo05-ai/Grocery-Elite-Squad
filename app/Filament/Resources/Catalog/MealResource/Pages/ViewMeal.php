<?php

namespace App\Filament\Resources\Catalog\MealResource\Pages;

use App\Filament\Resources\Catalog\MealResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMeal extends ViewRecord
{
    protected static string $resource = MealResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
