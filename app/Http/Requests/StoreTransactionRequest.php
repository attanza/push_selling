<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class StoreTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $role = Auth::user()->getRole();
        if ($role == 'seller') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required|max:50|unique:transactions,code,'.$this->id,
            'item_id' => 'required|integer',
            'seller_id' => 'required|integer',
            'outlet_id' => 'required|integer',
            'qty' => 'required|integer',
            'description' => 'nullable',
        ];
    }
}
