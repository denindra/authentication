<?php

namespace App\Http\Requests\UsersAdminRequest;


use Illuminate\Foundation\Http\FormRequest;

class UsersAdminDestroyValidation extends FormRequest
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
            'byId'       =>   'required|exists:admins,id',
            
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
