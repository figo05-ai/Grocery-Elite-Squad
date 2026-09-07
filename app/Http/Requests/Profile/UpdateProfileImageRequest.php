<?php

namespace App\Http\Requests\Profile;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProfileImageRequest extends FormRequest
{
    private const ONLY_ONE_IMAGE = 'Only one profile image is allowed';

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if (count($this->allFiles()) > 1 || is_array($this->file('image'))) {
            throw new HttpResponseException(
                response()->json([
                    'success' => false,
                    'message' => self::ONLY_ONE_IMAGE,
                    'errors'  => ['image' => [self::ONLY_ONE_IMAGE]],
                ], 422)
            );
        }
    }

    public function rules(): array
    {
        return [
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors(),
            ], 422)
        );
    }
}
