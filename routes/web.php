<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // Admin:
    Route::get('/adminDash', [AdminController::class, 'index'])->name('adminDash')->middleware('role:admin');
    Route::delete('/adminDash/destroy/{user}', [AdminController::class, 'destroy'])->middleware('role:admin');

    // filter
    Route::get('/filterPosts', [AdminController::class, 'filterPosts'])->name('newPosts')->middleware('role:admin');
    Route::post('/filterPosts', [AdminController::class, 'filterPosts'])->middleware('role:admin');

    // assign
    Route::post('/assign/{post}', [PostController::class, 'assign'])->middleware('role:admin');

    // delete post
    // Route::delete('/admin/post/destroy/{post}', [PostController::class, 'destroy'])->middleware('role:admin');


    // users:
    Route::get('/dashboard', [PostController::class, 'clientIndex'])->name('dashboard')->middleware('role:Client|Technician');
    ;

    // Client:
    Route::post('/post/store', [PostController::class, 'store'])->middleware('role:Client');
    Route::put('/post/update/{post}', [PostController::class, 'update'])->middleware('role:Client');

    
    // Technician:
    Route::put('/post/accept/{post}', [PostController::class, 'accept'])->middleware('role:Technician');
    
    // delete post
    Route::delete('/post/destroy/{post}', [PostController::class, 'destroy'])->middleware('role:Client|admin');
});

require __DIR__ . '/auth.php';
