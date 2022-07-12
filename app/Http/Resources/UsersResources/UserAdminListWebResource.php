<?php

namespace App\Http\Resources\UsersResources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserAdminListWebResource extends JsonResource
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
            'name'           => $this->resource['data']->name,

            'email'          =>  $this->resource['data']->email,
            'createdAt'      =>  $this->resource['data']->created_at,
            'updatedAt'      =>  $this->resource['data']->updated_at,
            'roles'          => $this->resource['data']->roles
        ];
    }
}
