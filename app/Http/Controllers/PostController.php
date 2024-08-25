<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::query()
        ->where('user_id',request()->user()->id)
        ->orderBy('created_at', 'desc')->paginate();
        return view('post.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'post' => ['required','string']
        ]);
        $data['user_id'] = $request->user()->id;
        $post = Post::create($data);
        return to_route('post.show', $post)->with('message', 'Post It was successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        if ($post->user_id !== request()->user()->id){
            abort(403);
        }
        return view('post.show', ['post' => $post]);
    }

    /**, ['posts' => $posts]
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        if ($post->user_id !== request()->user()->id){
            abort(403);
        }
        return view('post.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== request()->user()->id){
            abort(403);
        }
        $data = $request->validate([
            'post' => ['required','string']
        ]);
       
        $post->update($data);
        return to_route('post.show', $post)->with('message', 'Post It - updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if ($post->user_id !== request()->user()->id){
            abort(403);
        }
        $post->delete();
        return to_route('post.index')->with('message', 'Post It - deleted!');

    }
}
