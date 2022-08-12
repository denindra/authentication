<?php

namespace App\Http\Requests\AuthRequest;
use Illuminate\Foundation\Http\FormRequest;

class ResetNewPasswordRequest extends FormRequest
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
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'password_confirmation'=>'required|min:6'
        ];
    }
    public function messages()
    {
        return [
            'token.required'        => 'Token tidak dikenali',
            'email.email'           => 'Email format tidak benar',
            'email.required'        => 'Email tidak boleh kosong',
            'password.required'     => 'Password tidak boleh Kosong',
            'password.min'          => 'Password minimum 6 karaketer',
            'password.confirmed'    => 'password dan konfirmasi password tidak sama',
           ];
    }
}
