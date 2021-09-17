<?php

namespace App\Http\Resources\General;

use Illuminate\Http\Resources\Json\JsonResource;
use phpDocumentor\Reflection\Types\This;

class PostResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'status' => $this->status,
            'status_st' => $this->status(),
            'post_type' => $this->post_type,
            'comment_able' => $this->comment_able,
            'user_id' => $this->user_id,
            'user_name' => $this->user->name,
            'category_id' => $this->category_id,
            'category_name' => $this->category->name,
            'tags' => $this->tags,
//            'media' => $this->media,
        ];
    }
}
