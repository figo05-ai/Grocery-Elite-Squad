<?php

namespace App\Http\Resources\User\Profile\ProfileResource;

use App\Http\Resources\User\Address\AddressResource\AddressResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\User\User\User
 */
class ProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $user = $this->resource['user'];

        return [
            'me' => [
                'id' => $user->id,
                'profile_picture' => $user->profile_image_url,
                'name' => $user->full_name,
                'username' => $user->username,
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'gender' => $user->gender,
                'birthday' => $user->birthday?->format('Y-m-d'),
                'email' => $user->email,
                'phone' => $user->phone,
                'country_code' => $user->country_code,
                'email_verified' => $user->email_verified,
                'phone_verified' => $user->phone_verified,
                'preferred_languages' => $user->preferred_languages ?? [],
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ],
            'addresses' => AddressResource::collection($this->resource['addresses']),
            'order_history' => [
                'orders' => $this->resource['order_history'],
                'ordered_at' => collect($this->resource['order_history'])->map(fn ($o) => $o['placed_at'] ?? $o['created_at'])->values(),
            ],
            'in_progress_orders' => $this->resource['in_progress_orders'],
            'order_notifications' => $this->resource['order_notifications'],
            'settings' => [
                'privacy_and_security' => [
                    'active_sessions' => $this->resource['sessions'],
                    'change_password' => ['available' => true],
                    'change_username' => ['available' => true],
                ],
            ],
            'wishlist' => $this->resource['wishlist'],
        ];
    }
}
