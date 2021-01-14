<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store()
    {
        $data = request()->validate([
            'caption' => 'required',
            'image' => ['required', 'image']
        ]);

        dd(request('image')->store('uploads', 'public'));

        auth()->user()->posts()->create($data);
        // $post = new \App\Models\Post();

        // $post->caption = $data['capption'];
        // $post->save();

        // \App\Models\Post::create($data);



        dd(request()->all());
    }
}
