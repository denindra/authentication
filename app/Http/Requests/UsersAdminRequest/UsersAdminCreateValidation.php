<?php

namespace App\Http\Requests\UsersAdminRequest;

use Illuminate\Foundation\Http\FormRequest;

class UsersAdminCreateValidation extends FormRequest
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
            'name'       =>   'required',
            'email'      =>   'required|email|unique:admins,email',
            'password'   =>   'required|min:6',
            
        ];
    }
    public function messages()
    {
       return [
        'name.required'      => 'nama admin wajib diisi',

        'email.required'     => 'Email admin wajib diisi',
        'email.unique'       => 'email admin sudah terdaftar, silahkan gunakan email lainnya',

        'password.required'  => 'Password admin Wajib diisi',
        'password.min'       => 'minimum admin password 6 character'

       ]; 

    }
}
