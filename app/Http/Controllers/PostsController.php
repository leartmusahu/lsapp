<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
// use DB;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $posts = Post::all();
        // $posts = DB::select('SELECT * FROM posts');
        // $posts = Post::orderBy('title','desc')->take(1)->get();
        // $posts = Post::orderBy('t itle','desc')->get();
        
        $posts = Post::orderBy('created_at','desc')->paginate(10);
        return view('posts.index')->with('posts',$posts);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
        ]);

        //Creating post
            $post = new Post;
            $post->title = $request->input('title');
            $post->body = $request->input('body');
            $post->user_id= auth()->user()->id;
            $post->save();

            return redirect('/posts')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::find($id);
        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
        ]);

        //Creating post
            $post = Post::find($id);
            $post->title = $request->input('title');
            $post->body = $request->input('body');
            $post->save();

            return redirect('/posts')->with('success', 'Post updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);
        if ($post) {
            $post->delete();
            return redirect('/posts')->with('success', 'Post Deleted');
        } else {
            return redirect('/posts')->with('error', 'Post Not Found');
        }
    }
}
