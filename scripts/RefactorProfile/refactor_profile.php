<?php

$baseDir = __DIR__.'/../app';

function createDir($path)
{
    if (! is_dir($path)) {
        mkdir($path, 0755, true);
    }
}

// 1. Create ProfileResource
createDir("$baseDir/Http/Resources/User/Profile/ProfileResource");
$content = <<<PHP
<?php

namespace App\Http\Resources\User\Profile\ProfileResource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User\Address\AddressResource\AddressResource;

class ProfileResource extends JsonResource
{
    public function toArray(Request \$request): array
    {
        \$user = \$this->resource['user'];
        
        return [
            'me' => [
                'id' => \$user->id,
                'profile_picture' => \$user->profile_image_url,
                'name' => \$user->full_name,
                'username' => \$user->username,
                'firstname' => \$user->firstname,
                'lastname' => \$user->lastname,
                'gender' => \$user->gender,
                'birthday' => \$user->birthday?->format('Y-m-d'),
                'email' => \$user->email,
                'phone' => \$user->phone,
                'country_code' => \$user->country_code,
                'email_verified' => \$user->email_verified,
                'phone_verified' => \$user->phone_verified,
                'preferred_languages' => \$user->preferred_languages ?? [],
                'created_at' => \$user->created_at,
                'updated_at' => \$user->updated_at,
            ],
            'addresses' => AddressResource::collection(\$this->resource['addresses']),
            'order_history' => [
                'orders' => \$this->resource['order_history'],
                'ordered_at' => collect(\$this->resource['order_history'])->map(fn (\$o) => \$o['placed_at'] ?? \$o['created_at'])->values(),
            ],
            'in_progress_orders' => \$this->resource['in_progress_orders'],
            'order_notifications' => \$this->resource['order_notifications'],
            'settings' => [
                'privacy_and_security' => [
                    'active_sessions' => \$this->resource['sessions'],
                    'change_password' => ['available' => true],
                    'change_username' => ['available' => true],
                ],
            ],
            'wishlist' => \$this->resource['wishlist'],
        ];
    }
}
PHP;
file_put_contents("$baseDir/Http/Resources/User/Profile/ProfileResource/ProfileResource.php", $content);

// 2. Profile Services
createDir("$baseDir/Services/User/Profile/UpdateProfileInfoService");
$content = <<<PHP
<?php

namespace App\Services\User\Profile\UpdateProfileInfoService;

use App\Models\User\User\User;
use App\Models\User\Address\ValueObjects\PhoneNumber;

class UpdateProfileInfoService
{
    public function execute(User \$user, array \$data): User
    {
        if (isset(\$data['phone'])) {
            \$phoneNumber = new PhoneNumber(\$data['phone'], \$data['country_code'] ?? null);
            \$data['phone'] = \$phoneNumber->getNumber();
        }

        // Handle preferred_languages separately (can be empty array)
        if (isset(\$data['preferred_languages'])) {
            // keep it as is
        } else {
            unset(\$data['preferred_languages']);
        }

        // Remove empty values except preferred_languages
        \$data = array_filter(\$data, function (\$value, \$key) {
            if (\$key === 'preferred_languages') {
                return true;
            }
            return \$value !== null && \$value !== '';
        }, ARRAY_FILTER_USE_BOTH);

        if (!empty(\$data)) {
            \$user->update(\$data);
        }

        return \$user->fresh();
    }
}
PHP;
file_put_contents("$baseDir/Services/User/Profile/UpdateProfileInfoService/UpdateProfileInfoService.php", $content);

createDir("$baseDir/Services/User/Profile/ProfileImageService");
$content = <<<PHP
<?php

namespace App\Services\User\Profile\ProfileImageService;

use App\Models\User\User\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProfileImageService
{
    public function update(User \$user, UploadedFile \$image): User
    {
        if (\$user->profile_image && Storage::disk('public')->exists(\$user->profile_image)) {
            Storage::disk('public')->delete(\$user->profile_image);
        }

        \$path = \$image->store('profile-images', 'public');
        \$user->update(['profile_image' => \$path]);

        return \$user->fresh();
    }

    public function delete(User \$user): bool
    {
        if (! \$user->profile_image) {
            return false;
        }

        if (Storage::disk('public')->exists(\$user->profile_image)) {
            Storage::disk('public')->delete(\$user->profile_image);
        }

        \$user->update(['profile_image' => null]);
        return true;
    }
}
PHP;
file_put_contents("$baseDir/Services/User/Profile/ProfileImageService/ProfileImageService.php", $content);

// 3. Form Request for UpdateProfileInfo
createDir("$baseDir/Http/Requests/User/Profile/UpdateProfileInfoRequest");
$content = <<<PHP
<?php

namespace App\Http\Requests\User\Profile\UpdateProfileInfoRequest;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User\User\User;
use App\Rules\UsernameMustContainLetter;
use App\Support\EgyptianPhoneRules;
use App\Support\EmailValidation;
use Illuminate\Validation\Rule;

class UpdateProfileInfoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        \$userId = \$this->user()->id;
        
        return [
            'username' => ['sometimes', 'string', 'max:'.User::USERNAME_MAX_LENGTH, Rule::unique('users')->ignore(\$userId), 'not_regex:/\s/u', 'alpha_dash', new UsernameMustContainLetter],
            'firstname' => ['sometimes', 'string', 'max:255'],
            'lastname' => ['sometimes', 'string', 'max:255'],
            'gender' => ['sometimes', 'nullable', 'string', 'max:20', Rule::in(['male', 'female', 'other', 'prefer_not_to_say'])],
            'birthday' => ['sometimes', 'nullable', 'date', 'before:today'],
            'email' => ['sometimes', ...EmailValidation::formatRules(), 'max:255', Rule::unique('users')->ignore(\$userId)],
            'phone' => ['sometimes', 'string', EgyptianPhoneRules::internationalPrefixRule(), 'min:11', 'max:13', EgyptianPhoneRules::mobileRule(), Rule::unique('users')->ignore(\$userId)],
            'country_code' => ['sometimes', 'string', 'max:5', 'regex:/^\+\d{1,4}$/'],
            'preferred_languages' => ['sometimes', 'array'],
            'preferred_languages.*' => ['string', 'max:10'],
        ];
    }
}
PHP;
file_put_contents("$baseDir/Http/Requests/User/Profile/UpdateProfileInfoRequest/UpdateProfileInfoRequest.php", $content);

// 4. Update Controllers
$controllers = [
    'GetProfileController' => [
        'use' => "use App\Http\Resources\User\Profile\ProfileResource\ProfileResource;\nuse App\Traits\V1\ApiResponse;\nuse App\Models\Order;",
        'body' => <<<'PHP'
        $user = $request->user();
        $user->load(['addresses', 'favorites.meal.category', 'favorites.meal.subcategory']);

        $addresses = $user->addresses()->orderBy('is_default', 'desc')->orderBy('created_at', 'desc')->get();
        $allOrders = Order::where('user_id', $user->id)->with(['items.meal.category', 'items.meal.subcategory', 'address'])->orderBy('created_at', 'desc')->get();
        
        // Data formatters kept locally for now to avoid massive refactoring of Order/Catalog domains prematurely
        $orderHistory = $allOrders->map(fn (Order $o) => ['id' => $o->id, 'order_number' => $o->order_number, 'status' => $o->status, 'status_description' => $o->status_description, 'total' => (float) $o->total, 'placed_at' => $o->placed_at?->toIso8601String(), 'created_at' => $o->created_at?->toIso8601String(), 'item_count' => $o->items->count()]);
        
        $inProgressWithTracking = $allOrders->whereNotIn('status', ['cancelled', 'delivered'])->map(fn (Order $o) => ['id' => $o->id, 'order_number' => $o->order_number, 'status' => $o->status, 'total' => (float) $o->total])->values(); // Simplified for now
        
        $orderNotifications = $user->notifications()->take(20)->get()->map(fn ($n) => ['id' => $n->id, 'type' => $n->data['type'] ?? 'order', 'title' => $n->data['title'] ?? 'Order update', 'body' => $n->data['body'] ?? '', 'is_read' => $n->read_at !== null, 'created_at' => $n->created_at?->toIso8601String()]);
        
        $currentTokenId = $user->currentAccessToken()?->id;
        $sessions = $user->tokens()->get()->map(fn ($token) => ['id' => $token->id, 'name' => $token->name, 'last_used_at' => $token->last_used_at?->toIso8601String(), 'is_current' => (string) $token->id === (string) $currentTokenId])->all();
        
        $wishlist = $user->favorites->map(fn ($f) => ['id' => $f->meal->id, 'title' => $f->meal->title, 'is_favorited' => true])->values();

        $data = [
            'user' => $user,
            'addresses' => $addresses,
            'order_history' => $orderHistory,
            'in_progress_orders' => $inProgressWithTracking,
            'order_notifications' => $orderNotifications,
            'sessions' => $sessions,
            'wishlist' => $wishlist,
        ];

        return self::successResponse('Profile retrieved successfully', new ProfileResource($data));
PHP
    ],
    'UpdateProfileInfoController' => [
        'use' => "use App\Http\Requests\User\Profile\UpdateProfileInfoRequest\UpdateProfileInfoRequest;\nuse App\Services\User\Profile\UpdateProfileInfoService\UpdateProfileInfoService;\nuse App\Traits\V1\ApiResponse;",
        'body' => <<<'PHP'
        $service = app(UpdateProfileInfoService::class);
        $user = $service->execute($request->user(), $request->validated());
        
        return self::successResponse('Profile updated successfully', [
            'id' => $user->id,
            'username' => $user->username,
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'full_name' => $user->full_name,
            'phone' => $user->phone,
        ]);
PHP
    ],
    'UpdateProfileImageController' => [
        'use' => "use App\Services\User\Profile\ProfileImageService\ProfileImageService;\nuse App\Traits\V1\ApiResponse;",
        'body' => <<<'PHP'
        $request->validate([
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
        ]);
        
        $service = app(ProfileImageService::class);
        $user = $service->update($request->user(), $request->file('image'));
        
        return self::successResponse('Profile image updated successfully', [
            'profile_image' => $user->profile_image,
            'profile_image_url' => $user->profile_image_url,
        ]);
PHP
    ],
    'DeleteProfileImageController' => [
        'use' => "use App\Services\User\Profile\ProfileImageService\ProfileImageService;\nuse App\Traits\V1\ApiResponse;",
        'body' => <<<'PHP'
        $service = app(ProfileImageService::class);
        $success = $service->delete($request->user());
        
        if (!$success) {
            return self::errorResponse('No profile image to delete', [], 404);
        }
        
        return self::successResponse('Profile image deleted successfully');
PHP
    ],
    'GetUserSessionsController' => [
        'use' => "use App\Traits\V1\ApiResponse;",
        'body' => <<<'PHP'
        $user = $request->user();
        $currentTokenId = $user->currentAccessToken()?->id;

        $tokens = $user->tokens()->get()->map(function ($token) use ($currentTokenId) {
            return [
                'id' => $token->id,
                'name' => $token->name,
                'last_used_at' => $token->last_used_at?->toIso8601String(),
                'is_current' => (string) $token->id === (string) $currentTokenId,
                'created_at' => $token->created_at?->toIso8601String(),
            ];
        });

        return self::successResponse('Sessions retrieved successfully', $tokens);
PHP
    ],
    'DestroyUserSessionController' => [
        'use' => "use App\Traits\V1\ApiResponse;",
        'body' => <<<'PHP'
        $user = $request->user();
        $currentTokenId = $user->currentAccessToken()?->id;

        if ((string) $id === (string) $currentTokenId) {
            return self::errorResponse('Cannot revoke your current session from this request. Use logout instead.', [], 400);
        }

        $token = $user->tokens()->find($id);
        if (! $token) {
            return self::errorResponse('Session not found', [], 404);
        }

        $token->delete();
        return self::successResponse('Session revoked successfully');
PHP
    ],
];

foreach ($controllers as $controller => $data) {
    $path = "$baseDir/Http/Controllers/User/Profile/$controller/$controller.php";
    if (! file_exists($path)) {
        createDir("$baseDir/Http/Controllers/User/Profile/$controller");
    }

    // Determine input param for invoke
    $param = 'Request $request';
    if ($controller === 'UpdateProfileInfoController') {
        $param = 'UpdateProfileInfoRequest $request';
    } elseif ($controller === 'DestroyUserSessionController') {
        $param = 'Request $request, string $id';
    }

    $content = <<<PHP
<?php

namespace App\Http\Controllers\User\Profile\\$controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
{$data['use']}

class $controller extends Controller
{
    use ApiResponse;

    public function __invoke($param): JsonResponse
    {
{$data['body']}
    }
}
PHP;
    file_put_contents($path, $content);
}

// Routes update
$file = __DIR__.'/../routes/api.php';
$content = file_get_contents($file);

$imports = [
    'use App\Http\Controllers\User\Profile\GetProfileController\GetProfileController;',
    'use App\Http\Controllers\User\Profile\UpdateProfileInfoController\UpdateProfileInfoController;',
    'use App\Http\Controllers\User\Profile\UpdateProfileImageController\UpdateProfileImageController;',
    'use App\Http\Controllers\User\Profile\DeleteProfileImageController\DeleteProfileImageController;',
    'use App\Http\Controllers\User\Profile\GetUserSessionsController\GetUserSessionsController;',
    'use App\Http\Controllers\User\Profile\DestroyUserSessionController\DestroyUserSessionController;',
];

$content = str_replace('use App\Http\Controllers\Api\ProfileController;', implode("\n", $imports), $content);

$content = str_replace("Route::get('/profile', [ProfileController::class, 'show']);", "Route::get('/profile', GetProfileController::class);", $content);
$content = str_replace("Route::put('/profile/info', [ProfileController::class, 'updateInfo']);", "Route::put('/profile/info', UpdateProfileInfoController::class);", $content);
$content = str_replace("Route::post('/profile/image', [ProfileController::class, 'updateImage']);", "Route::post('/profile/image', UpdateProfileImageController::class);", $content);
$content = str_replace("Route::delete('/profile/image', [ProfileController::class, 'deleteImage']);", "Route::delete('/profile/image', DeleteProfileImageController::class);", $content);
$content = str_replace("Route::get('/profile/sessions', [ProfileController::class, 'sessions']);", "Route::get('/profile/sessions', GetUserSessionsController::class);", $content);
$content = str_replace("Route::delete('/profile/sessions/{id}', [ProfileController::class, 'destroySession']);", "Route::delete('/profile/sessions/{id}', DestroyUserSessionController::class);", $content);

file_put_contents($file, $content);

@unlink("$baseDir/Http/Controllers/Api/ProfileController.php");

echo "Profile Domain corrections completed.\n";
