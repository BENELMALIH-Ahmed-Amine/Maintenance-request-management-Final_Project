<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    
    // admin
    Route::get('/adminDash', [AdminController::class, 'index'])->name('adminDash')->middleware('role:admin');
    Route::delete('/adminDash/destroy/{user}', [AdminController::class, 'destroy'])->middleware('role:admin');
    
    Route::get('/newPosts', [AdminController::class, 'newPosts'])->name('newPosts')->middleware('role:admin');
    Route::delete('/admin/post/destroy/{post}', [PostController::class, 'destroy'])->middleware('role:admin');
    
    
    // users
    Route::get('/clientProfile', [PostController::class, 'clientIndex'])->name('clientProfile');
    Route::post('/post/store', [PostController::class, 'store'])->middleware('role:Client');

    Route::put('/post/update/{post}', [PostController::class, 'update'])->middleware('role:Client');
    Route::delete('/post/destroy/{post}', [PostController::class, 'destroy'])->middleware('role:Client');

});

require __DIR__ . '/auth.php';
