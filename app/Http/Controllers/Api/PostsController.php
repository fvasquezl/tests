<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostStoreRequest;

class PostsController extends Controller
{
    public function store(PostStoreRequest $request)
    {
        $post = $request->createPost();
        return response(['success'=> 'The post has been successfully created']);
    }
}
