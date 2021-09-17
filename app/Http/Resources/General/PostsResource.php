<?php

namespace App\Http\Resources\General;

use Database\Seeders\TagsTableSeeder;
use Illuminate\Http\Resources\Json\JsonResource;
use phpDocumentor\Reflection\Types\This;

class PostsResource extends JsonResource
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
            'title'         => $this->title,
            'slug'          => $this->slug,
            'url'           => route('posts.show', $this->slug),
            'description'   => $this->description,
            'status'        => $this->status,
            'status_st'     => $this->status(),
            'comment_able'  => $this->comment_able,
            'create_date'   => $this->created_at->format('d-m-Y h:i a'),
            'auther'        => new UsersResource($this->user),
            'category'      => new CategoriesResource($this->category),
            'tags'          => TagsResource::collection($this->tags),
            'media'         => PostsMediaResource::collection($this->media),
            'comment_count' => $this->comments->where('status', 1)->count(),
        ];
    }
}
