<?php

namespace App\Services\User\Address\CreateAddressService;

use App\Models\User\Address\Address;
use App\Models\User\Address\ValueObjects\PhoneNumber\PhoneNumber;
use App\Models\User\User\User;
use Illuminate\Support\Facades\DB;

class CreateAddressService
{
    public function execute(User $user, array $data): Address
    {
        return DB::transaction(function () use ($user, $data) {
            $isFirstAddress = $user->addresses()->count() === 0;

            $isDefault = false;
            if (isset($data['is_default'])) {
                $isDefault = (bool) $data['is_default'];
            }

            $data['is_default'] = $isDefault || $isFirstAddress;

            $phoneNumber = new PhoneNumber($data['phone'] ?? '', $data['country_code'] ?? null);
            $data['phone'] = $phoneNumber->getNumber();

            return $user->addresses()->create($data);
        });
    }
}
