<?php

namespace App\Http\Requests\UsersRequest;

use Illuminate\Foundation\Http\FormRequest;

class UsersDestroyValidation extends FormRequest
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
            'byId'       =>   'required||exists:users,id',
            
        ];
    }
    public function messages()
    {
       return [
        'byId.required'      => 'id wajib diisi',
        'byId.exists'        => 'id tidak ditemukan',
       ]; 

    }
}
