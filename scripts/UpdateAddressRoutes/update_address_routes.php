<?php

$file = __DIR__.'/../routes/api.php';
$content = file_get_contents($file);

$imports = [
    'use App\Http\Controllers\User\Address\GetAddressesController\GetAddressesController;',
    'use App\Http\Controllers\User\Address\CreateAddressController\CreateAddressController;',
    'use App\Http\Controllers\User\Address\GetAddressController\GetAddressController;',
    'use App\Http\Controllers\User\Address\UpdateAddressController\UpdateAddressController;',
    'use App\Http\Controllers\User\Address\DeleteAddressController\DeleteAddressController;',
    'use App\Http\Controllers\User\Address\SetDefaultAddressController\SetDefaultAddressController;',
];

$content = str_replace('use App\Http\Controllers\Api\AddressController;', implode("\n", $imports), $content);

$content = str_replace("Route::get('/', [AddressController::class, 'index']);", "Route::get('/', GetAddressesController::class);", $content);
$content = str_replace("Route::post('/', [AddressController::class, 'store']);", "Route::post('/', CreateAddressController::class);", $content);
$content = str_replace("Route::get('/{id}', [AddressController::class, 'show']);", "Route::get('/{id}', GetAddressController::class);", $content);
$content = str_replace("Route::put('/{id}', [AddressController::class, 'update']);", "Route::put('/{id}', UpdateAddressController::class);", $content);
$content = str_replace("Route::delete('/{id}', [AddressController::class, 'destroy']);", "Route::delete('/{id}', DeleteAddressController::class);", $content);
$content = str_replace("Route::post('/{id}/set-default', [AddressController::class, 'setDefault']);", "Route::post('/{id}/set-default', SetDefaultAddressController::class);", $content);

file_put_contents($file, $content);
echo "Address Routes updated.\n";

// Update namespaces for Address Model
$baseDir = __DIR__.'/../app';
$routesDir = __DIR__.'/../routes';
$dirs = [$baseDir, $routesDir];
foreach ($dirs as $dir) {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $f) {
        if ($f->isFile() && $f->getExtension() === 'php') {
            $path = $f->getPathname();
            $c = file_get_contents($path);
            $newC = $c;

            $newC = str_replace("App\Models\Address;", "App\Models\User\Address\Address;", $newC);
            $newC = str_replace("App\Models\Address::", "App\Models\User\Address\Address::", $newC);
            $newC = preg_replace('/use App\\\\Models\\\\Address;/', 'use App\\Models\\User\\Address\\Address;', $newC);

            if ($c !== $newC) {
                file_put_contents($path, $newC);
            }
        }
    }
}
echo "Address Model namespaces updated.\n";
