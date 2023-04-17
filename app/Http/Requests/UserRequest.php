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
        $routeName = $this->route()->getName();

        return [
            'name'=>[$routeName == 'user.register' ? 'required' : 'nullable' , 'min:3' , 'max:35'],
            'email'=>[$routeName == 'user.register' ? 'unique:users' : 'nullable' , 'email' , 'required_without:phone'],
            'phone'=>[$routeName == 'user.register' ? 'unique:users' : 'nullable' , 'digits:11' , 'required_without:email'],
            'password'=>'required|between:8,30',
            'c_password'=>[$routeName == 'user.register' ? 'required' : 'nullable' , 'same:password'],
            // 'password_confirmation'=>'required',
        ];
    }
}
