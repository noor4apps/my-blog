<?php

namespace App\Http\Resources\Users;

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
            'name'          => $this->name,
            'email'         => $this->email,
            'mobile'        => $this->mobile,
            'user_image'    => $this->user_image(),
            'status'        => $this->status,
            'status_text'   => $this->status(),
            'bio'           => $this->bio,
            'receive_email' => $this->receive_email,
        ];
    }
}
