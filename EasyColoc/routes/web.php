<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth', 'check.banned'])->group(function () {


    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::middleware('is.admin')->prefix('admin')->name('admin.')->group(function () {

        Route::get('/dashboard',            [AdminController::class, 'dashboard'])->name('dashboard');
        Route::patch('/users/{user}/ban',   [AdminController::class, 'ban'])->name('users.ban');
        Route::patch('/users/{user}/unban', [AdminController::class, 'unban'])->name('users.unban');

    });

});

require __DIR__.'/auth.php';
