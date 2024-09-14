<?php

namespace App\Http\Requests\OrderRequest;

use App\Models\Order;
use App\Models\OrderType;
use App\Models\OrderWorker;
use App\Models\Worker;
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
            'order_id' => 'required|integer|exists:orders,id',
            'status' => 'required|string|max:255',
            'worker_id' => 'required|exists:workers,id',
            'amount' => 'required|integer',
        ];
    }

    /**
     * Get the "after" validation callables for the request.
     */
    public function after(): array
    {
        return [
            function (Validator $validator) {
                $orderId = $this->input('order_id');
                $workerId = $this->input('worker_id');
                $amount = $this->input('amount');

                /**@var Order $order */
                $order = Order::find($orderId);

                $orderWorker = $order->orderWorkers()
                    ->leftJoin('orders', 'order_workers.id', '=', 'orders.order_worker_id')
                    ->get()
                    ->firstWhere('worker_id', $workerId);

                if ($orderWorker) {
                    $validator->errors()->add(
                        'worker_id',
                        sprintf('Исполнитель с id:%s назначен ранее', $workerId)
                    );
                }

                $orderType = DB::table('order_types')
                    ->leftJoin('orders', 'order_types.id', '=', 'orders.order_type_id')
                    ->leftJoin('worker_ex_order_types', 'order_types.id', '=', 'worker_ex_order_types.order_type_id')
                    ->leftJoin('workers', 'worker_ex_order_types.worker_id', '=', 'workers.id')
                    ->where('orders.id', '=', $orderId)
                    ->where('worker_ex_order_types.worker_id', '=', $workerId)
                    ->get()
                    ->toArray();

                if ([] == $orderType) {
                    $validator->errors()->add(
                        'worker_id',
                        sprintf('Исполнитель с id:%s не может выполнить такой заказ', $workerId,)
                    );
                }

                if ($order->amount < $amount) {
                    $validator->errors()->add(
                        'amount',
                        sprintf('Количество amount:%s превышает допустимое значение', $amount)
                    );
                }
            }
        ];
    }
}
