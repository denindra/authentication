<?php

namespace App\Http\Resources\UsersResources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserListWebResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       
        return [
            'id'             => $this->resource['data']->id,
            'uuid'           => $this->resource['data']->uuid,
            'nama'           => $this->resource['data']->name,
           
            'email'          =>  $this->resource['data']->email,
            'tanggal_dibuat' =>  $this->resource['data']->created_at,
            'tanggal_Update' =>  $this->resource['data']->updated_at,
        ];
    }
}
