<?php

namespace App\Services\User\Address\DeleteAddressService;

use App\Models\User\User\User;
use Illuminate\Support\Facades\DB;

class DeleteAddressService
{
    public function execute(User $user, string $addressId): void
    {
        $address = $user->addresses()->findOrFail($addressId);

        DB::transaction(function () use ($user, $address) {
            $wasDefault = $address->is_default;
            $address->delete();

            if ($wasDefault) {
                $newDefault = $user->addresses()->first();
                if ($newDefault) {
                    $newDefault->update(['is_default' => true]);
                }
            }
        });
    }
}
