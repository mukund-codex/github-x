<?php

use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return ['Laravel' => app()->version()];
})->name('home');

Route::prefix('/admin')->group(function() {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'index'])->name('admin.login');
        Route::post('/login', [AdminLoginController::class, 'store'])->name('admin.login.store');
    });

    Route::middleware('role:super_admin')->group(function() {

        Route::middleware(['auth', 'verified'])->group(function () {
            Route::get('/', function () {
                return view('dashboard');
            })->name('admin.dashboard');
            Route::get('/profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('admin.profile.update');
            Route::put('password', [ProfileController::class, 'updatePassword'])->name('admin.password.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('admin.profile.destroy');
        });

        Route::post('logout', [AdminLoginController::class, 'destroy'])
            ->name('admin.logout');
    });
});


