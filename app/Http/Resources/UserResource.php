<?php

namespace App\Http\Resources;

use App\Utils\Constants;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id' => $this->_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
//            'role' => $this->role['value'],
            'status' => $this->deleted_at ? Constants::$STATUS['inactive'] : Constants::$STATUS['active'],
        ];
    }
}
