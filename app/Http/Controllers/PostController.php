<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostCollection;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\Post as PostResource;

class PostController extends Controller
{
    public function index()
    {
        return new PostCollection(request()->user()->posts);
    }

    public function store()
    {
        $data = request()->validate([
            'data.attributes.body' => '',

        ]);

//        dd($data);

        $post = request()->user()->posts()->create($data['data']['attributes']);
//        $post = Post::create($data);
//        dd($post = request()->user()->posts());
        return new PostResource($post);
    }
}
