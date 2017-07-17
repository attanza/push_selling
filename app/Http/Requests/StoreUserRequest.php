<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::id() == $this->id || Auth::user()->roles()->first()->slug == 'admin') {
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
            'name' => 'required|max:150',
            'email' => 'required|email|max:150|unique:users,email,'.$this->id,
            'username' => 'required|max:150|unique:users,username,'.$this->id,
            'ktp' => 'nullable|max:30',
            'gender' => 'nullable|max:10',
            'dob' => 'nullable|date',
            'phone1' => 'nullable|max:30',
            'phone2' => 'nullable|max:30',
            'address' => 'nullable',
            'role' => 'required|integer'
        ];
    }
}
