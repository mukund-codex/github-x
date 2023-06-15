<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware(['auth:sanctum'])->group(function() {
    Route::controller(ProfileController::class)
        ->prefix('/profile')
        ->group( function() {
            Route::get('/', 'show')->name('profile.show');
            Route::patch('/', 'update')->name('profile.update');
            Route::delete('/', 'destroy')->name('profile.destroy');
    });
    Route::controller(UserController::class)
        ->prefix('/users')
        ->group( function() {
            Route::get('/{user}', 'show')
                ->name('users.show')
                ->can('view user');
            Route::post('/', 'store')
                ->name('users.store')
                ->can('create user');
            Route::patch('/{user}', 'update')
                ->name('users.update')
                ->can('update user');
            Route::get('/', 'index')
                ->name('users.index')
                ->can('view users');
            Route::delete('/{user}', 'destroy')
                ->name('users.destroy')
                ->can('delete user');
    });
});

Route::get('/', function () {
    return ['this-is-laravel-api' => app()->version()];
});

require __DIR__.'/auth.php';
