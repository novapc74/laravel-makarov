<?php

namespace App\Http\Requests\OrderRequest;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
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
        return [
            'description' => 'required|string|max:1000',
            'date' => 'required|date',
            'address' => 'required|string|max:1000',
            'amount' => 'required|integer',
            'status' => 'required|string|max:255',
            'order_type_id' => 'required|exists:order_types,id',
            'user_id' => 'required|exists:users,id',
            'partnership_id' => 'nullable|exists:partnerships,id',
            'created_at' => 'nullable|date',
            'updated_at' => 'nullable|date'
        ];
    }
}
