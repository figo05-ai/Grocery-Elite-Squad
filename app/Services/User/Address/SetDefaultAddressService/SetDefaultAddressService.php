<?php

namespace App\Services\User\Address\SetDefaultAddressService;

use App\Models\User\User\User;
use Illuminate\Support\Facades\DB;

class SetDefaultAddressService
{
    public function execute(User $user, string $addressId): array
    {
        $address = $user->addresses()->findOrFail($addressId);

        if ($address->is_default) {
            return [
                'already_default' => true,
                'address' => $address,
            ];
        }

        $address = DB::transaction(function () use ($user, $address) {
            $user->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
            $address->update(['is_default' => true]);

            return $address->fresh();
        });

        return [
            'already_default' => false,
            'address' => $address,
        ];
    }
}
