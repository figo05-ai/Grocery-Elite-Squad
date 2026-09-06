<?php

namespace App\Services\User\Profile\UpdateProfileInfoService;

use App\Models\User\Address\ValueObjects\PhoneNumber\PhoneNumber;
use App\Models\User\User\User;

class UpdateProfileInfoService
{
    public function execute(User $user, array $data): User
    {
        if (isset($data['phone'])) {
            $phoneNumber = new PhoneNumber($data['phone'], $data['country_code'] ?? null);
            $data['phone'] = $phoneNumber->getNumber();
        }

        // Handle preferred_languages separately (can be empty array)
        if (isset($data['preferred_languages'])) {
            // keep it as is
        } else {
            unset($data['preferred_languages']);
        }

        // Remove empty values except preferred_languages
        $data = array_filter($data, function ($value, $key) {
            if ($key === 'preferred_languages') {
                return true;
            }

            return $value !== null && $value !== '';
        }, ARRAY_FILTER_USE_BOTH);

        if (! empty($data)) {
            $user->update($data);
        }

        return $user->fresh();
    }
}
