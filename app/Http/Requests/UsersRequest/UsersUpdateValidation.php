<?php

namespace App\Http\Requests\UsersRequest;

use Illuminate\Foundation\Http\FormRequest;

class UsersUpdateValidation extends FormRequest
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
            'email'      =>   'required|unique:users,email,'.$this->id,
            'id'         =>   'required',
          
        ];
    }
     public function messages()
    {
       return [
        'name.required'      => 'nama wajib diisi',
        'email.required'     => 'Email wajib diisi',
        'email.unique'       => 'email sudah terdaftar, silahkan gunakan email lainnya',

       ]; 

    }
}
