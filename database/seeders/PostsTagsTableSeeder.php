<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class PostsTagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = Post::Post()->get();

        foreach ($posts as $post)
        {
            $tags = Tag::inRandomOrder()->take(3)->pluck('id')->toArray();
            $post->tags()->sync($tags);
        }
    }
}
