<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'Required|min:5',
            'excerpt' => 'Required|min:5',
            'published_at' => 'Required'
        ]);

        $post = Post::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'excerpt' => $request->excerpt,
            'published_at' => $request->published_at
        ]);

        return response(['post' => $post]);
    }
}
