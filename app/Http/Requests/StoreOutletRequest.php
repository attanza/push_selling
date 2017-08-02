<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOutletRequest extends FormRequest
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
            'market_id' => 'required|integer',
            'code' => 'required|max:50|unique:outlets,code,'.$this->id,
            'name' => 'required|max:50|unique:outlets,name,'.$this->id,
            'owner' => 'required|max:50',
            'pic' => 'required|max:50',
            'phone1' => 'required|max:30',
            'phone2' => 'nullable|max:30',
            'email' => 'required|email|max:150|unique:stokiests,code,'.$this->id,
            'address' => 'nullable',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ];
    }
}
