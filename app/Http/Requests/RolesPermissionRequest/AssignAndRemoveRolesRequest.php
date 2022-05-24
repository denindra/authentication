<?php

namespace App\Http\Requests\RolesPermissionRequest;

use Illuminate\Foundation\Http\FormRequest;

class AssignAndRemoveRolesRequest extends FormRequest
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
            'id' => 'required',
            'roleName.*' => 'required|string',
          
        ];
    }
    public function messages()
    {
        return [
            'id.required'        => 'id  tidak boleh kosong',
            'roleName.*'        => 'role  tidak boleh kosong',
            'roleName.string' => 'gunakan nama role untuk menambah/ menghapus role',
           
           ]; 
    }
}
