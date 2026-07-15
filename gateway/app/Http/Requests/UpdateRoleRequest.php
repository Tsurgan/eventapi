<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;
use Illuminate\Support\Facades\Gate;
use App\Models\Role;

#[OA\Schema(
    schema: "UpdateRoleRequest",
    properties: [
        new OA\Property(property: "name", type: "string", example: "Manager"),
        new OA\Property(property: "is_default", type: "boolean", example: "true"),
    ]
)]

class UpdateRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
         return Gate::allows('update', [Role::class, $this->route('id')]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'max:255', 'unique:roles,name,'.$this->route('id')],
            'is_default' =>['sometimes', 'boolean'],
        ];
    }
}
