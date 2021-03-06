<?php

namespace App\Http\Resources;

use App\Utils\Constants;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    //Todo Fix this resource issue
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
            'name' => $this->name,
            'tag' => $this->tag,
            'category' => $this->category,
            'image' => $this->image,
//            'thumbnail' => $this->thumbnail, //Todo not required this sprint
            'status' => $this->deleted_at ? Constants::$STATUS['inactive'] : Constants::$STATUS['active'],
        ];
    }
}
