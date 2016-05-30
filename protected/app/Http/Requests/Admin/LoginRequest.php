<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class LoginRequest extends Request
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
            'email' => 'required|email|max:255',
            'password' => 'required'
        ];
    }

    public function messages(){
        return [
            'email.required' => 'Vui long nhap email',
            'email.email' => 'Vui long nhap dung email',
            'email.max' => 'Vui long nhap email toi da 255 ky tu',
            'password.required' => 'Vui long nhap password'
        ];
    }
}
