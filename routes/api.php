<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\v1\ProfileController;
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
});

Route::get('/', function () {
    return ['this-is-laravel-api' => app()->version()];
});

require __DIR__.'/auth.php';
