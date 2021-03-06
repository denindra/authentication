<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginByEmailRequestValidation extends FormRequest
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
        return  [
            'email'      =>   'required|email',
            'password'   =>   'required',  
        ];
    }
    public function messages()
    {
       return [
        'email.required'      => 'Email wajib diisi',
        'email.email'         => 'Email format tidak benar',
        'password.required'  => 'Password wajib diisi',
       ]; 
    }
}
