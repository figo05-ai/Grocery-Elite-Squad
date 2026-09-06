<?php

namespace App\Services\User\Address\UpdateAddressService;

use App\Models\User\Address\Address;
use App\Models\User\Address\ValueObjects\PhoneNumber\PhoneNumber;
use App\Models\User\User\User;
use Illuminate\Support\Facades\DB;

class UpdateAddressService
{
    public function execute(User $user, string $addressId, array $updateData): Address
    {
        $address = $user->addresses()->findOrFail($addressId);

        return DB::transaction(function () use ($address, $updateData) {
            if (isset($updateData['phone'])) {
                $phoneNumber = new PhoneNumber($updateData['phone'], $updateData['country_code'] ?? null);
                $updateData['phone'] = $phoneNumber->getNumber();
            }

            $address->fill($updateData)->save();

            return $address->fresh();
        });
    }
}
