<?php

namespace App\Http\Requests\UsersRequest;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'current_password'        => 'required',
            'password'                => 'required|confirmed|min:6',
        ];
    }
    public function messages()
    {
       return [
        'current_password.required'      => 'Password Saat ini Wajib diisi',
        'password.required'              => 'Password Baru Wajib Diisi',
        'password.confirmed'             => 'password dan konfirmasi password tidak sama',
        'password.min'                   => 'password minimum 6 karakter',
       ]; 

    }
}
