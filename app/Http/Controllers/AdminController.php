<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
     * Show the form for creating a new resource.
     */
    public function newPosts()
    {
        $statuses = Status::all();
        $categorys = Category::all();

        $clientPosts = Post::whereHas('status', function ($query) {
            $query->where('name', 'Une Semaine - أسبوع');
        })->get();

        return view('admin.newPosts', compact('categorys', 'clientPosts', 'statuses'));
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
        //
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
