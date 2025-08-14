<?php

use App\Http\Controllers\AdminDashController;
use App\Http\Controllers\ProfileController;
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
    
    
    Route::get('/adminDash', [AdminDashController::class, 'index'])->name('adminDash')->middleware('role:admin');
    Route::delete('/adminDash/destroy/{user}', [AdminDashController::class, 'destroy'])->middleware('role:admin');
});

require __DIR__.'/auth.php';
