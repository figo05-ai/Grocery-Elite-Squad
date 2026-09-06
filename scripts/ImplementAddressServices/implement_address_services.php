<?php

$baseDir = __DIR__.'/../app';

function createDir($path)
{
    if (! is_dir($path)) {
        mkdir($path, 0755, true);
    }
}

// 1. Address Responses
createDir("$baseDir/Http/Responses/User/Address/AddressResponse");
$content = <<<PHP
<?php

namespace App\Http\Responses\User\Address\AddressResponse;

use Illuminate\Http\JsonResponse;
use App\Models\Address;
use App\Http\Responses\Shared\SuccessResponse;

class AddressResponse
{
    public static function make(string \$message, Address \$address, int \$status = 200): JsonResponse
    {
        return SuccessResponse::make(\$message, self::format(\$address), \$status);
    }

    public static function format(Address \$address): array
    {
        return [
            'id' => \$address->id,
            'label' => \$address->label,
            'full_name' => \$address->full_name,
            'phone' => \$address->phone,
            'country_code' => \$address->country_code,
            'formatted_phone' => \$address->formatted_phone,
            'street_address' => \$address->street_address,
            'building_number' => \$address->building_number,
            'floor' => \$address->floor,
            'apartment' => \$address->apartment,
            'landmark' => \$address->landmark,
            'city' => \$address->city,
            'state' => \$address->state,
            'postal_code' => \$address->postal_code,
            'country' => \$address->country,
            'notes' => \$address->notes,
            'is_default' => \$address->is_default,
            'latitude' => \$address->latitude,
            'longitude' => \$address->longitude,
            'full_address' => \$address->full_address,
            'created_at' => \$address->created_at,
            'updated_at' => \$address->updated_at,
        ];
    }
}
PHP;
file_put_contents("$baseDir/Http/Responses/User/Address/AddressResponse/AddressResponse.php", $content);

createDir("$baseDir/Http/Responses/User/Address/AddressListResponse");
$content = <<<PHP
<?php

namespace App\Http\Responses\User\Address\AddressListResponse;

use Illuminate\Http\JsonResponse;
use App\Http\Responses\Shared\SuccessResponse;
use App\Http\Responses\User\Address\AddressResponse\AddressResponse;
use Illuminate\Support\Collection;

class AddressListResponse
{
    public static function make(string \$message, Collection \$addresses, int \$status = 200): JsonResponse
    {
        \$formatted = \$addresses->map(function (\$address) {
            return AddressResponse::format(\$address);
        });

        return SuccessResponse::make(\$message, [
            'addresses' => \$formatted,
            'total_count' => \$formatted->count(),
        ], \$status);
    }
}
PHP;
file_put_contents("$baseDir/Http/Responses/User/Address/AddressListResponse/AddressListResponse.php", $content);

// 2. Implement CreateAddressService
$content = <<<PHP
<?php

namespace App\Services\User\Address\CreateAddressService;

use App\Models\User\User\User;
use App\Models\Address;
use Illuminate\Support\Facades\DB;

class CreateAddressService
{
    public function execute(User \$user, array \$data): Address
    {
        return DB::transaction(function () use (\$user, \$data) {
            \$isFirstAddress = \$user->addresses()->count() === 0;
            
            \$isDefault = false;
            if (isset(\$data['is_default'])) {
                \$isDefault = (bool) \$data['is_default'];
            }
            
            \$data['is_default'] = \$isDefault || \$isFirstAddress;

            \$phone = trim(\$data['phone'] ?? '');
            \$code = trim(\$data['country_code'] ?? '');
            if (\$code !== '' && str_starts_with(\$phone, \$code)) {
                \$data['phone'] = substr(\$phone, strlen(\$code));
            }

            return \$user->addresses()->create(\$data);
        });
    }
}
PHP;
file_put_contents("$baseDir/Services/User/Address/CreateAddressService/CreateAddressService.php", $content);

// 3. Implement UpdateAddressService
$content = <<<PHP
<?php

namespace App\Services\User\Address\UpdateAddressService;

use App\Models\User\User\User;
use App\Models\Address;
use Illuminate\Support\Facades\DB;

class UpdateAddressService
{
    public function execute(User \$user, string \$addressId, array \$updateData): Address
    {
        \$address = \$user->addresses()->findOrFail(\$addressId);

        return DB::transaction(function () use (\$address, \$updateData) {
            if (isset(\$updateData['phone'], \$updateData['country_code']) && \$updateData['country_code'] !== '' && str_starts_with(trim(\$updateData['phone']), \$updateData['country_code'])) {
                \$updateData['phone'] = substr(trim(\$updateData['phone']), strlen(\$updateData['country_code']));
            }

            \$address->fill(\$updateData)->save();

            return \$address->fresh();
        });
    }
}
PHP;
file_put_contents("$baseDir/Services/User/Address/UpdateAddressService/UpdateAddressService.php", $content);

// 4. Implement DeleteAddressService
$content = <<<PHP
<?php

namespace App\Services\User\Address\DeleteAddressService;

use App\Models\User\User\User;
use Illuminate\Support\Facades\DB;

class DeleteAddressService
{
    public function execute(User \$user, string \$addressId): void
    {
        \$address = \$user->addresses()->findOrFail(\$addressId);

        DB::transaction(function () use (\$user, \$address) {
            \$wasDefault = \$address->is_default;
            \$address->delete();

            if (\$wasDefault) {
                \$newDefault = \$user->addresses()->first();
                if (\$newDefault) {
                    \$newDefault->update(['is_default' => true]);
                }
            }
        });
    }
}
PHP;
file_put_contents("$baseDir/Services/User/Address/DeleteAddressService/DeleteAddressService.php", $content);

// 5. Implement SetDefaultAddressService
$content = <<<PHP
<?php

namespace App\Services\User\Address\SetDefaultAddressService;

use App\Models\User\User\User;
use App\Models\Address;
use Illuminate\Support\Facades\DB;

class SetDefaultAddressService
{
    public function execute(User \$user, string \$addressId): array
    {
        \$address = \$user->addresses()->findOrFail(\$addressId);

        if (\$address->is_default) {
            return [
                'already_default' => true,
                'address' => \$address,
            ];
        }

        \$address = DB::transaction(function () use (\$user, \$address) {
            \$user->addresses()->where('id', '!=', \$address->id)->update(['is_default' => false]);
            \$address->update(['is_default' => true]);

            return \$address->fresh();
        });

        return [
            'already_default' => false,
            'address' => \$address,
        ];
    }
}
PHP;
file_put_contents("$baseDir/Services/User/Address/SetDefaultAddressService/SetDefaultAddressService.php", $content);

echo "Address Domain Services and Responses created.\n";
