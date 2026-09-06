<?php

namespace App\Services\User\Profile\ProfileImageService;

use App\Models\User\User\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProfileImageService
{
    public function update(User $user, UploadedFile $image): User
    {
        if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
            Storage::disk('public')->delete($user->profile_image);
        }

        $path = $image->store('profile-images', 'public');
        $user->update(['profile_image' => $path]);

        return $user->fresh();
    }

    public function delete(User $user): bool
    {
        if (! $user->profile_image) {
            return false;
        }

        if (Storage::disk('public')->exists($user->profile_image)) {
            Storage::disk('public')->delete($user->profile_image);
        }

        $user->update(['profile_image' => null]);

        return true;
    }
}
