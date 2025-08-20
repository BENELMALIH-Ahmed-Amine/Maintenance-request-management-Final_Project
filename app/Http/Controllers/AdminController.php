<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Termwind\Components\Dd;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::whereDoesntHave('roles', function ($function) {
            $function->where('name', 'admin');
        })->get();
        
        return view('admin.adminDash', compact('users'));
    }

    /**
     * Filters the resources.
     */
    public function filterPosts(Request $request)
    {
        // Filter:
        $statuses = Status::all();
        $categorys = Category::all();

        $category_id = $request->category_id;
        $status_id = $request->status_id;

        $query = Post::query();

        if ($category_id) {
            $query->where('category_id', $category_id);
        }

        if ($status_id) {
            $query->where('status_id', $status_id);
        }

        $posts = $query->get();

        // Techs:
        $techs = User::all();


        return view('admin.newPosts', compact('categorys', 'posts', 'statuses', 'techs'));
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

    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $path = $user->profil;
        $storage = Storage::disk('public');

        if ($storage->exists($path)) {
            $storage->delete($path);
        }

        $user->delete();
        return back();
    }
}
