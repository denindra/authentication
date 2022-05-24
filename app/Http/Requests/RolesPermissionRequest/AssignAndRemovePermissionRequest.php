<?php

namespace App\Http\Requests\RolesPermissionRequest;

use Illuminate\Foundation\Http\FormRequest;

class AssignAndRemovePermissionRequest extends FormRequest
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
            'permissionName.*' => 'required|string',
          
        ];
    }
    public function messages()
    {
        return [
            'id.required'        => 'id  tidak boleh kosong',
            'permissionName.*'        => 'permission  tidak boleh kosong',
            'permissionName.string' => 'gunakan nama permission untuk menambah/ menghapus role',
           
           ]; 
    }
}
