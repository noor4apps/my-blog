<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = [];

    public function sluggable()
    {
        return [
          'slug' => [
              'source' => 'name'
          ]
        ];
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'posts_tags');
    }

}
