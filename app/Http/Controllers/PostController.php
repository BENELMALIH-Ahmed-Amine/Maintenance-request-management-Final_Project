<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function clientIndex()
    {
        $clientPosts = Post::where('user_id', '=', Auth::user()->id)->get();

        $categorys = Category::all();
        $statuses = Status::all();
        return view('profile.clientProfile', compact('clientPosts', 'categorys', 'statuses'));
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
            'description' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'status_id' => 'required',
            'category_id' => 'required',
            'user_id' => 'required'
        ]);

        $path = $request->file('image')->store('Posts', 'public');

        Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $path,
            'status_id' => $request->status_id,
            'category_id' => $request->category_id,
            'user_id' => $request->user_id,
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
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'status_id' => 'required',
            'category_id' => 'required',
            'user_id' => 'required'
        ]);

        $path = storage_path('app/public/' . $post->image);

        if (file_exists($path)) {
            $storage = Storage::disk('public');
            $storage->delete($path);

            $request->image->move(storage_path('app/public/' . $post->image));
        }

        $post->update([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $path,
            'status_id' => $request->status_id,
            'category_id' => $request->category_id,
            'user_id' => $request->user_id,
        ]);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $path = $post->image;
        $storage = Storage::disk('public');

        if ($storage->exists($path)) {
            $storage->delete($path);
        }

        $post->delete();
        return back();
    }
}
