<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name'=>'required|min:3|max:35',
            'email'=>'required|email|unique:users',
            'password'=>'required|between:8,30',
            'c_password'=>'required|same:password',
            'phone'=>'digits:11|unique:users',
            // 'password_confirmation'=>'required',
        ];
    }
}
