<?php

namespace App\Http\Requests\OrderRequest;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class OrderPostRequest extends FormRequest
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
            'description' => 'required|string|max:1000',
            'date' => 'required|date',
            'address' => 'required|string|max:1000',
            'amount' => 'required|integer',
            'status' => 'required|string|max:255',
            'order_type_id' => 'required|exists:order_types,id',
            'user_id' => 'required|exists:users,id',
            'partnership_id' => 'required|exists:partnerships,id',
            'created_at' => 'nullable|date',
            'updated_at' => 'nullable|date'
        ];
    }

    #TODO проверяем вылидность пар id для user_id & partnership_id
    public function after(): array
    {
        return [
            function (Validator $validator) {
                $partnerShipId = $this->input('partnership_id');
                $userId = $this->input('user_id');

                $partnership = DB::table('partnerships')->leftJoin('users', 'partnerships.id', '=', 'users.partnership_id')
                    ->where('partnerships.id', '=', $partnerShipId)
                    ->where('users.id', '=', $userId)
                    ->get()->toArray();


                if ([] == $partnership) {
                    $validator->errors()->add(
                        'user_id',
                        'Указанный пользователь не может создавать заказы для выбранного партнера'
                    );
                }
            }
        ];
    }
}
