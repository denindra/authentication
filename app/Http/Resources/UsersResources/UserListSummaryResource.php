<?php

namespace App\Http\Resources\UsersResources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserListSummaryResource extends JsonResource
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
            'uuid'             => $this->resource['data']->uuid,
            'nama'             => $this->resource['data']->name,
        ];
    }
}
