<?php

namespace App\Http\Livewire\Backend;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Livewire\Component;

class LastStatistics extends Component
{
    public function render()
    {
        $all_users = User::whereHas('roles', function ($query) {
            $query->where('name', 'user');
        })->active()->count();

        $active_posts = Post::active()->post()->count();
        $inactive_posts = Post::inactive()->post()->count();
        $active_comments = Comment::active()->count();

        return view('livewire.backend.last-statistics', [
            'all_users' => $all_users,
            'active_posts' => $active_posts,
            'inactive_posts' => $inactive_posts,
            'active_comments' => $active_comments,
        ]);
    }
}
