<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ];
    }
    
    public function messages()
    {
        return [
            'username.required' => 'Vui lòng điền tên đăng nhập',
            'username.unique' => 'Tên đăng nhập này đã tồn tại',
            'email.required' => 'Vui lòng nhập email',
            'email.unique' => 'Email này đã được đăng ký',
            'email.email' => 'Vui lòng nhập đúng email',
            'password.required' => 'Vui lòng nhập mật khẩu',
        ];
    }
}

