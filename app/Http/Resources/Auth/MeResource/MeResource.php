<?php

namespace App\Http\Resources\Auth\MeResource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\User\User\User
 */
class MeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'username' => $this->resource->username,
            'email' => $this->resource->email,
            'phone' => $this->resource->phone,
        ];
    }
}
