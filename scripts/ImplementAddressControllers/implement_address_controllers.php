<?php

$baseDir = __DIR__.'/../app';

$controllers = [
    'User/Address/GetAddressesController' => <<<PHP
<?php

namespace App\Http\Controllers\User\Address\GetAddressesController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Responses\User\Address\AddressListResponse\AddressListResponse;
use App\Http\Responses\Shared\SuccessResponse;

class GetAddressesController extends Controller
{
    public function __invoke(Request \$request): JsonResponse
    {
        if (\$request->allFiles() !== []) {
            return response()->json([
                'status' => 422,
                'message' => 'This endpoint does not accept file uploads.',
                'data' => ['files' => ['Remove file attachments from the request.']]
            ], 422);
        }

        \$user = \$request->user();
        \$addresses = \$user->addresses()
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return AddressListResponse::make('Addresses retrieved successfully', \$addresses, 200);
    }
}
PHP,
    'User/Address/CreateAddressController' => <<<PHP
<?php

namespace App\Http\Controllers\User\Address\CreateAddressController;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Address\AddressRequest\AddressRequest;
use App\Services\User\Address\CreateAddressService\CreateAddressService;
use App\Http\Responses\User\Address\AddressResponse\AddressResponse;
use Illuminate\Http\JsonResponse;
use Exception;

class CreateAddressController extends Controller
{
    public function __construct(protected CreateAddressService \$service) {}

    public function __invoke(AddressRequest \$request): JsonResponse
    {
        try {
            \$address = \$this->service->execute(\$request->user(), \$request->validated());
            return AddressResponse::make('Address created successfully', \$address, 201);
        } catch (Exception \$e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to create address.',
                'data' => null
            ], 500);
        }
    }
}
PHP,
    'User/Address/GetAddressController' => <<<PHP
<?php

namespace App\Http\Controllers\User\Address\GetAddressController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Responses\User\Address\AddressResponse\AddressResponse;
use Illuminate\Http\JsonResponse;

class GetAddressController extends Controller
{
    public function __invoke(Request \$request, string \$id): JsonResponse
    {
        \$user = \$request->user();
        \$address = \$user->addresses()->findOrFail(\$id);

        return AddressResponse::make('Address retrieved successfully', \$address, 200);
    }
}
PHP,
    'User/Address/UpdateAddressController' => <<<PHP
<?php

namespace App\Http\Controllers\User\Address\UpdateAddressController;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Address\AddressRequest\AddressRequest;
use App\Services\User\Address\UpdateAddressService\UpdateAddressService;
use App\Http\Responses\User\Address\AddressResponse\AddressResponse;
use Illuminate\Http\JsonResponse;
use Exception;

class UpdateAddressController extends Controller
{
    public function __construct(protected UpdateAddressService \$service) {}

    public function __invoke(AddressRequest \$request, string \$id): JsonResponse
    {
        try {
            \$address = \$this->service->execute(\$request->user(), \$id, \$request->validated());
            return AddressResponse::make('Address updated successfully', \$address, 200);
        } catch (Exception \$e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to update address.',
                'data' => null
            ], 500);
        }
    }
}
PHP,
    'User/Address/DeleteAddressController' => <<<PHP
<?php

namespace App\Http\Controllers\User\Address\DeleteAddressController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\User\Address\DeleteAddressService\DeleteAddressService;
use App\Http\Responses\Shared\SuccessResponse;
use Illuminate\Http\JsonResponse;
use Exception;

class DeleteAddressController extends Controller
{
    public function __construct(protected DeleteAddressService \$service) {}

    public function __invoke(Request \$request, string \$id): JsonResponse
    {
        try {
            \$this->service->execute(\$request->user(), \$id);
            return SuccessResponse::make('Address deleted successfully', [], 200);
        } catch (Exception \$e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to delete address.',
                'data' => null
            ], 500);
        }
    }
}
PHP,
    'User/Address/SetDefaultAddressController' => <<<PHP
<?php

namespace App\Http\Controllers\User\Address\SetDefaultAddressController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\User\Address\SetDefaultAddressService\SetDefaultAddressService;
use App\Http\Responses\Shared\SuccessResponse;
use App\Http\Responses\User\Address\AddressResponse\AddressResponse;
use Illuminate\Http\JsonResponse;
use Exception;

class SetDefaultAddressController extends Controller
{
    public function __construct(protected SetDefaultAddressService \$service) {}

    public function __invoke(Request \$request, string \$id): JsonResponse
    {
        try {
            \$result = \$this->service->execute(\$request->user(), \$id);
            
            if (\$result['already_default']) {
                return SuccessResponse::make('This address is already your default.', [
                    'already_default' => true,
                    'address' => AddressResponse::format(\$result['address']),
                ], 200);
            }

            return SuccessResponse::make('Default address updated successfully', [
                'already_default' => false,
                'address' => AddressResponse::format(\$result['address']),
            ], 200);
        } catch (Exception \$e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to set default address.',
                'data' => null
            ], 500);
        }
    }
}
PHP
];

foreach ($controllers as $controller => $content) {
    $parts = explode('/', $controller);
    $className = end($parts);
    file_put_contents("$baseDir/Http/Controllers/$controller/$className.php", $content);
}

// Move Address Model
if (file_exists("$baseDir/Models/Address.php")) {
    $content = file_get_contents("$baseDir/Models/Address.php");
    $content = str_replace("namespace App\Models;", "namespace App\Models\User\Address;", $content);

    if (! is_dir("$baseDir/Models/User/Address")) {
        mkdir("$baseDir/Models/User/Address", 0755, true);
    }
    file_put_contents("$baseDir/Models/User/Address/Address.php", $content);
    unlink("$baseDir/Models/Address.php");
}

@unlink("$baseDir/Http/Controllers/Api/AddressController.php");

echo "Address Domain Controllers implemented and model moved.\n";
