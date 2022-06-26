<?php

namespace App\Http\Requests\UsersAdminRequest;

use Illuminate\Foundation\Http\FormRequest;

class UsersAdminUpdateValidation extends FormRequest
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
            'email'      =>   'required|email|unique:admins,email,'.$this->id,
            'id'         =>   'required',
          
        ];
    }
    public function messages()
    {
       return [
        'name.required'      => 'nama admin wajib diisi',
        'email.required'     => 'Email admin wajib diisi',
        'email.unique'       => 'email admin sudah terdaftar, silahkan gunakan email lainnya',
       ]; 

    }
}
