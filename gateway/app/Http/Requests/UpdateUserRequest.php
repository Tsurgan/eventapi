<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "UpdateUserRequest",
    properties: [
        new OA\Property(property: "name", type: "string", example: "john1doe"),
        new OA\Property(property: "email", type: "string", example: "john@example.com"),
        new OA\Property(property: "password", type: "string", example: "secret1234"),
        new OA\Property(property: "password_confirmation", type: "string", example: "secret1234")
    ]
)]

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->user()->id;
        return [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,'.$userId],
            'password' => ['required', 'min:6', 'confirmed'],
        ];
    }
}
