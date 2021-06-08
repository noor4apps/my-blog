<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];

    public function status()
    {
        return $this->status == 1 ? 'Active' : 'Inactive';
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
