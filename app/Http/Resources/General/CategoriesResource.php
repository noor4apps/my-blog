<?php

namespace App\Http\Resources\General;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Route;

class CategoriesResource extends JsonResource
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
            'name'      => $this->name,
            'slug'      => $this->slug,
            'status'    => $this->status(),
            'url'       => route('frontend.category.posts', $this->slug),
            'posts_count' => $this->posts->where('post_type', 'post')->where('status', 1)->count(),
        ];
    }
}
