<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Category;
use App\Models\ChMessage;
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
        if (Auth::user()->hasRole('Client')) {
            // Client's posts
            $posts = Post::where('user_id', Auth::user()->id)->with(['assignment.user'])->get();
        } else {
            // Technician's assigned posts
            $posts = Post::whereHas('assignment', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })->with('user')->get();
        }


        $categorys = Category::all();
        $statuses = Status::all();


        // Unread messages
        $unreadCounts = ChMessage::where('to_id', Auth::user()->id)->where('seen', 0)->count();

        return view('dashboard', compact('posts', 'categorys', 'statuses', 'unreadCounts'));
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
     * Assing posts.
     */

    public function assign(Request $request, Post $post)
    {
        $request->validate(['user_id' => 'required']);

        // Create or update assignment
        Assignment::updateOrCreate(
            ['post_id' => $post->id],
            ['user_id' => $request->user_id]
        );

        return back()->with('success', 'Technician assigned successfully!');
    }

    /**
     * Update post's status.
     */
    public function accept(Request $request, Post $post)
    {
        $request->validate(['status_id' => 'required']);

        $post->update(['status_id' => $request->status_id]);

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
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'status_id' => 'nullable',
            'category_id' => 'nullable',
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
