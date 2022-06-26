<?php

namespace App\Http\Requests\AuthRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProfileAdminRequest extends FormRequest
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
        $checkHeaderAuth = Auth::user($this->header('Authorization'));

        return  [
            'email'      =>   'required|email|unique:admins,email,'.$checkHeaderAuth->id,
            'name'       =>   'required',
        ];
    }
     public function messages()
    {
        return [
            'email.required'      => 'Email wajib diisi',
            'email.unique'       => 'Email sudah terdaftar, silahkan gunakan email lain',
            'email.email'         => 'Email format tidak benar',
            'name.required'      => 'Nama wajib diisi',
           ]; 
    }
}
