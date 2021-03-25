<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($model) {
                return [
                    'id' => $model->id,
                    'uuid' => $model->uuid,
                    'name' => $model->name,
                    'email' => $model->email,
                    'active' => $model->active,
                    'role' => $model->getRoleNames()->first(),
                    'created_at' => $model->created_at->toDateString()
                ];
            }),
            'total' => $this->total()
        ];
    }
}
