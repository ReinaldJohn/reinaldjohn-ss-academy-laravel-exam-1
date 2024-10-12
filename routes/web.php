<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersListController;

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

    Route::name('users.')->group(function() {
        Route::get('/users', [UsersListController::class, 'index'])->name('users');
        Route::get('/user', [UsersListController::class, 'fetchUser'])->name('user');

        Route::get('/create-user', [UserController::class, 'createUserIndex'])->name('create-user.index');
        Route::get('/edit-user', [UserController::class, 'editUserIndex'])->name('edit-user.index');
        Route::get('/delete-user', [UserController::class, 'deleteUserIndex'])->name('delete-user.index');

        Route::get('/fetch-user-info', [UserController::class, 'fetchUserInfo'])->name('user-info-fetch');

        Route::resources([
            'manage-users' => UserController::class
        ]);

        Route::get('/trashed-users', [UserController::class, 'trashedUsersIndex'])->name('trashed-users.index');

        Route::softDeletes('users', UserController::class);

    });
});

require __DIR__.'/auth.php';
