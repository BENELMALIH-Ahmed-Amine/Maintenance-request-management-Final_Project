<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function clientIndex()
    {
        $clientPosts = Post::where('user_id', '=', Auth::user()->id)->get();

        $categorys = Category::all();
        return view('profile.clientProfile', compact('clientPosts', 'categorys'));
    }

    /**
     * Display a listing of the resourceer_id.
     */
    public function TechIndex()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'dectiption' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'priority' => ['required', 'string'],
            'category_id' => 'required',
            'user_id' => 'required'
        ]);

        $path = $request->file('image')->store('Posts', 'public');

        Post::create([
            'title' => $request->title,
            'dectiption' => $request->dectiption,
            'priority' => $request->priority,
            'category_id' => $request->category_id,
            'user_id' => $request->user_id,
            'image' => $path,
        ]);

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
