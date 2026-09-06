<?php

$baseDir = __DIR__.'/../app';

function createDir($path)
{
    if (! is_dir($path)) {
        mkdir($path, 0755, true);
    }
}

// 1. Create PhoneNumber Value Object
createDir("$baseDir/Models/User/Address/ValueObjects");
$content = <<<PHP
<?php

namespace App\Models\User\Address\ValueObjects;

use InvalidArgumentException;

class PhoneNumber
{
    private string \$number;
    private ?string \$countryCode;

    public function __construct(string \$number, ?string \$countryCode = null)
    {
        \$this->countryCode = \$countryCode ? trim(\$countryCode) : null;
        \$this->number = \$this->normalize(\$number);
    }

    private function normalize(string \$number): string
    {
        \$number = trim(\$number);
        if (\$this->countryCode !== null && \$this->countryCode !== '' && str_starts_with(\$number, \$this->countryCode)) {
            return substr(\$number, strlen(\$this->countryCode));
        }
        return \$number;
    }

    public function getNumber(): string
    {
        return \$this->number;
    }

    public function getCountryCode(): ?string
    {
        return \$this->countryCode;
    }
}
PHP;
file_put_contents("$baseDir/Models/User/Address/ValueObjects/PhoneNumber.php", $content);

// 2. Create AddressResource (JsonResource)
createDir("$baseDir/Http/Resources/User/Address/AddressResource");
$content = <<<PHP
<?php

namespace App\Http\Resources\User\Address\AddressResource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    public function toArray(Request \$request): array
    {
        return [
            'id' => \$this->id,
            'label' => \$this->label,
            'full_name' => \$this->full_name,
            'phone' => \$this->phone,
            'country_code' => \$this->country_code,
            'formatted_phone' => \$this->formatted_phone,
            'street_address' => \$this->street_address,
            'building_number' => \$this->building_number,
            'floor' => \$this->floor,
            'apartment' => \$this->apartment,
            'landmark' => \$this->landmark,
            'city' => \$this->city,
            'state' => \$this->state,
            'postal_code' => \$this->postal_code,
            'country' => \$this->country,
            'notes' => \$this->notes,
            'is_default' => \$this->is_default,
            'latitude' => \$this->latitude,
            'longitude' => \$this->longitude,
            'full_address' => \$this->full_address,
            'created_at' => \$this->created_at,
            'updated_at' => \$this->updated_at,
        ];
    }
}
PHP;
file_put_contents("$baseDir/Http/Resources/User/Address/AddressResource/AddressResource.php", $content);

// 3. Update Services
$createService = "$baseDir/Services/User/Address/CreateAddressService/CreateAddressService.php";
if (file_exists($createService)) {
    $content = file_get_contents($createService);
    $content = str_replace("use App\Models\User\Address\Address;", "use App\Models\User\Address\Address;\nuse App\Models\User\Address\ValueObjects\PhoneNumber;", $content);

    // Replace the raw string logic with the Value Object
    $oldLogic = <<<'PHP'
            $phone = trim($data['phone'] ?? '');
            $code = trim($data['country_code'] ?? '');
            if ($code !== '' && str_starts_with($phone, $code)) {
                $data['phone'] = substr($phone, strlen($code));
            }
PHP;
    $newLogic = <<<'PHP'
            $phoneNumber = new PhoneNumber($data['phone'] ?? '', $data['country_code'] ?? null);
            $data['phone'] = $phoneNumber->getNumber();
PHP;
    $content = str_replace($oldLogic, $newLogic, $content);
    file_put_contents($createService, $content);
}

$updateService = "$baseDir/Services/User/Address/UpdateAddressService/UpdateAddressService.php";
if (file_exists($updateService)) {
    $content = file_get_contents($updateService);
    $content = str_replace("use App\Models\User\Address\Address;", "use App\Models\User\Address\Address;\nuse App\Models\User\Address\ValueObjects\PhoneNumber;", $content);

    $oldLogic = <<<'PHP'
            if (isset($updateData['phone'], $updateData['country_code']) && $updateData['country_code'] !== '' && str_starts_with(trim($updateData['phone']), $updateData['country_code'])) {
                $updateData['phone'] = substr(trim($updateData['phone']), strlen($updateData['country_code']));
            }
PHP;
    $newLogic = <<<'PHP'
            if (isset($updateData['phone'])) {
                $phoneNumber = new PhoneNumber($updateData['phone'], $updateData['country_code'] ?? null);
                $updateData['phone'] = $phoneNumber->getNumber();
            }
PHP;
    $content = str_replace($oldLogic, $newLogic, $content);
    file_put_contents($updateService, $content);
}

// 4. Update Controllers
$controllers = [
    'GetAddressesController' => [
        'use' => "use App\Http\Resources\User\Address\AddressResource\AddressResource;\nuse App\Traits\V1\ApiResponse;",
        'body' => <<<'PHP'
        if ($request->allFiles() !== []) {
            return self::errorResponse('This endpoint does not accept file uploads.', ['files' => ['Remove file attachments from the request.']], 422);
        }

        $user = $request->user();
        $addresses = $user->addresses()
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return self::successResponse('Addresses retrieved successfully', [
            'addresses' => AddressResource::collection($addresses),
            'total_count' => $addresses->count()
        ], 200);
PHP
    ],
    'CreateAddressController' => [
        'use' => "use App\Http\Resources\User\Address\AddressResource\AddressResource;\nuse App\Traits\V1\ApiResponse;",
        'body' => <<<'PHP'
        $address = $this->service->execute($request->user(), $request->validated());
        return self::successResponse('Address created successfully', new AddressResource($address), 201);
PHP
    ],
    'GetAddressController' => [
        'use' => "use App\Http\Resources\User\Address\AddressResource\AddressResource;\nuse App\Traits\V1\ApiResponse;",
        'body' => <<<'PHP'
        $user = $request->user();
        $address = $user->addresses()->findOrFail($id);
        return self::successResponse('Address retrieved successfully', new AddressResource($address), 200);
PHP
    ],
    'UpdateAddressController' => [
        'use' => "use App\Http\Resources\User\Address\AddressResource\AddressResource;\nuse App\Traits\V1\ApiResponse;",
        'body' => <<<'PHP'
        $address = $this->service->execute($request->user(), $id, $request->validated());
        return self::successResponse('Address updated successfully', new AddressResource($address), 200);
PHP
    ],
    'DeleteAddressController' => [
        'use' => "use App\Traits\V1\ApiResponse;",
        'body' => <<<'PHP'
        $this->service->execute($request->user(), $id);
        return self::successResponse('Address deleted successfully', [], 200);
PHP
    ],
    'SetDefaultAddressController' => [
        'use' => "use App\Http\Resources\User\Address\AddressResource\AddressResource;\nuse App\Traits\V1\ApiResponse;",
        'body' => <<<'PHP'
        $result = $this->service->execute($request->user(), $id);
        
        $message = $result['already_default'] ? 'This address is already your default.' : 'Default address updated successfully';
        
        return self::successResponse($message, [
            'already_default' => $result['already_default'],
            'address' => new AddressResource($result['address']),
        ], 200);
PHP
    ],
];

foreach ($controllers as $controller => $data) {
    $path = "$baseDir/Http/Controllers/User/Address/$controller/$controller.php";
    if (! file_exists($path)) {
        continue;
    }

    $content = file_get_contents($path);

    if (! str_contains($content, 'use ApiResponse;')) {
        $content = preg_replace('/class\s+'.$controller.'\s+extends\s+Controller\s*{/', "class $controller extends Controller\n{\n    use ApiResponse;\n", $content);
    }

    $content = preg_replace('/use App\\\\Http\\\\Responses\\\\User\\\\Address\\\\[a-zA-Z]+\\\\[a-zA-Z]+;/', '', $content);
    $content = preg_replace('/use App\\\\Http\\\\Responses\\\\Shared\\\\SuccessResponse;/', '', $content);
    $content = preg_replace('/use Exception;/', '', $content);

    $content = str_replace('use Illuminate\Http\JsonResponse;', "use Illuminate\Http\JsonResponse;\n".$data['use'], $content);

    // Replace __invoke body
    if (str_contains($content, 'public function __invoke(Request $request)')) {
        $content = preg_replace('/public function __invoke\(Request \$request\)\s*:\s*JsonResponse\s*\{.*?\n    \}/s', "public function __invoke(Request \$request): JsonResponse\n    {\n".$data['body']."\n    }", $content);
    } else {
        $content = preg_replace('/public function __invoke\([^)]+\)\s*:\s*JsonResponse\s*\{.*?\n    \}/s', 'public function __invoke('.preg_replace('/.*public function __invoke\(([^)]+)\).*/s', '$1', $content)."): JsonResponse\n    {\n".$data['body']."\n    }", $content);
    }

    file_put_contents($path, $content);
}

// 5. Cleanup Custom Responses
function rrmdir($dir)
{
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != '.' && $object != '..') {
                if (is_dir($dir.DIRECTORY_SEPARATOR.$object) && ! is_link($dir.'/'.$object)) {
                    rrmdir($dir.DIRECTORY_SEPARATOR.$object);
                } else {
                    unlink($dir.DIRECTORY_SEPARATOR.$object);
                }
            }
        }
        rmdir($dir);
    }
}
rrmdir("$baseDir/Http/Responses/User/Address");

echo "Address Domain corrections completed.\n";
