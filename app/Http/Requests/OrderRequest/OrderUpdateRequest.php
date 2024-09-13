<?php

namespace App\Http\Requests\OrderRequest;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class OrderUpdateRequest extends FormRequest
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
            'description' => 'nullable|string|max:1000',
            'date' => 'nullable|date',
            'address' => 'nullable|string|max:1000',
            'amount' => 'nullable|integer',
            'status' => 'nullable|string|max:255',
            'order_type_id' => 'nullable|exists:order_types,id',
            'user_id' => 'nullable|exists:users,id',
            'partnership_id' => 'required|exists:partnerships,id',
            'order_worker_id' => 'nullable|exists:partnerships,id',
            'created_at' => 'nullable|date',
            'updated_at' => 'nullable|date'
        ];
    }
}
