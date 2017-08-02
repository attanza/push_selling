<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required|max:50|unique:items,code,'.$this->id,
            'name' => 'required|max:100|unique:items,code,'.$this->id,
            'measurement' => 'required|max:25',
            'price' => 'sometimes|numeric',
            'target_by' => 'required|integer',
            'target_count' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date'
        ];
    }
}
