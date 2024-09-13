<?php

namespace App\Http\Requests\OrderRequest;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class OrderUpdateRequest extends FormRequest
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
            'partnership_id' => 'nullable|exists:partnerships,id',
            'order_worker_id' => 'nullable|exists:order_workers,id',
            'created_at' => 'nullable|date',
            'updated_at' => 'nullable|date'
        ];
    }

    /**
     * Get the "after" validation callables for the request.
     */
    public function after(): array
    {
        return [
            function (Validator $validator) {
                $orderWorkerId = $this->input('order_worker_id');
                $orderType = $this->input('order_type_id');

                $worker = DB::table('workers')->addSelect('workers.id')
                    ->leftJoin('worker_ex_order_types', 'workers.id', '=', 'worker_ex_order_types.worker_id')
                    ->where('worker_ex_order_types.order_type_id', '=', $orderType)
                    ->where('workers.id', '=', $orderWorkerId)
                    ->get()
                    ->toArray();

//                dd($worker);

                if ([] !== $worker) {
                    $validator->errors()->add(
                        'order_worker_id',
                        'Исполнитель не может выполнять такие заказы'
                    );
                }
            }
        ];
    }
}
