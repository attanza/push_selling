<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UpdateMarketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $role = Auth::user()->roles()->first()->slug;
        if ($role == 'admin' || $role == 'supervisor') {
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
            'name' => 'required|max:50|unique:markets,name,'.$this->id,
            'area_id' => 'required|integer',
            'address' => 'nullable',
            'description' => 'nullable',
            'photo' => 'image|max:5000'
        ];
    }
}
