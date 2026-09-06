<?php

namespace App\Http\Requests\Cart;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCartItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $max = config('cart.max_quantity_per_product', 10);

        return [
            'quantity' => ['required', 'integer', 'min:1', 'max:' . $max],
        ];
    }

    public function messages(): array
    {
        $max = config('cart.max_quantity_per_product', 10);

        return [
            'quantity.max' => "Maximum {$max} units per product allowed.",
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
