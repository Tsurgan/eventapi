<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

#[OA\Schema(
    schema: "UpdateUserRequest",
    properties: [
        new OA\Property(property: "name", type: "string", example: "john1doe"),
        new OA\Property(property: "email", type: "string", example: "john@example.com"),
        new OA\Property(property: "phone", type: "string", example: "89999999999"),
        new OA\Property(property: "password", type: "string", example: "secret1234"),
        new OA\Property(property: "password_confirmation", type: "string", example: "secret1234"),
        new OA\Property(property: "role_id", type: "integer", example: "2"),
    ]
)]

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('update', [User::class, $this->route('id')]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'max:255'],
            'email' => ['sometimes', 'email', 'unique:users,email,' . $this->route('id')],
            'phone' => ['sometimes', 'digits_between:10,15','unique:users,phone,' . $this->route('id')],
            'password' => ['sometimes', 'min:6', 'confirmed'],
            'role_id' => ['sometimes','integer'],
        ];
    }
}
