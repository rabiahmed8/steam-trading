<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SearchContoller;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard',[PostController::class, 'find']);
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [PostController::class, 'find'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/submit-form', [PostController::class, 'store'])->name('create-post');

    Route::get('profile-picture', [PostController::class, 'showProfilePicture'])->name('profile.picture');
});
Route::get('/search', [SearchContoller::class, 'search'])->name('search');

require __DIR__ . '/auth.php';
