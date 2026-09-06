<?php

namespace App\Filament\Resources\User\OtpResource\Pages;

use App\Filament\Resources\User\OtpResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOtp extends EditRecord
{
    protected static string $resource = OtpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
