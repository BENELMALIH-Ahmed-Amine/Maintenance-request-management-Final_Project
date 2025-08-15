<?php

use App\Http\Controllers\AdminDashController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $categorys = Category::all();
    $posts = Post::all();
    return view('dashboard', compact('categorys', 'posts'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // admin
    Route::get('/adminDash', [AdminDashController::class, 'index'])->name('adminDash')->middleware('role:admin');
    Route::delete('/adminDash/destroy/{user}', [AdminDashController::class, 'destroy'])->middleware('role:admin');
    
    // users
    Route::get('/clientProfile', [UsersController::class, 'clientIndex'])->name('clientProfile');
    Route::post('/post/store', [UsersController::class, 'store']);
});

require __DIR__.'/auth.php';
