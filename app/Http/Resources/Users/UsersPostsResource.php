<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\JsonResource;

class UsersPostsResource extends JsonResource
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
            'id'            => $this->id,
            'title'         => $this->title,
            'slug'          => $this->slug,
            'status'        => $this->status,
            'status_text'   => $this->status(),
            'comment_able'  => $this->comment_able,
            'create_date'   => $this->created_at->format('d-m-Y h:i a'),
            'comment_count' => $this->comments->where('status', 1)->count(),
        ];
    }
}
