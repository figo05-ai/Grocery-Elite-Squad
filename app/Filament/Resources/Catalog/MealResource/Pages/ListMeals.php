<?php

namespace App\Filament\Resources\Catalog\MealResource\Pages;

use App\Filament\Resources\Catalog\MealResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMeals extends ListRecords
{
    protected static string $resource = MealResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
