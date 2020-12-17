<?php

namespace App\Http\Resources\Member;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'email' => $this->email,
            'roles' => $this->getRoleNames(),
            'permissions' => $this->getPermissionNames()
        ];
    }
}
