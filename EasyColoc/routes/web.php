<?php

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
});

require __DIR__.'/auth.php';


Route::middleware(['auth', 'check.banned', 'is.admin'])
     ->prefix('admin')
     ->name('admin.')
     ->group(function () {

         Route::get('/dashboard',            [AdminController::class, 'dashboard'])->name('dashboard');
         Route::patch('/users/{user}/ban',   [AdminController::class, 'ban'])->name('users.ban');
         Route::patch('/users/{user}/unban', [AdminController::class, 'unban'])->name('users.unban');
     });
