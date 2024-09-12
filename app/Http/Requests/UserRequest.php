<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string',
            'email' => 'required|string|unique',
            'password' => 'string|min:8|max:255',
        ];

        return match($this->getMethod()) {
            'POST' => $rules,
            'PUT' => array_merge($rules, [
                'partnership_id' => 'required|integer|exists:partnerships,id'
            ]),
        };
    }
}
