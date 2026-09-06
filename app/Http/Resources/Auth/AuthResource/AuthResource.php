<?php

namespace App\Http\Resources\Auth\AuthResource;

use App\Models\User\User\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */
class AuthResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'user' => [
                'id' => $this->resource['user']->id,
                'username' => $this->resource['user']->username,
                'email' => $this->resource['user']->email,
                'phone' => $this->resource['user']->phone,
                // Add other user fields as necessary
            ],
            'token' => $this->resource['token'],
        ];
    }
}
