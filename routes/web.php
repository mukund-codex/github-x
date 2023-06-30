<?php

use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleListController;
use App\Http\Controllers\UserController;
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

    Route::middleware('permission:view dashboard')->group(function() {

        Route::middleware(['auth', 'verified'])->group(function () {
            Route::get('/', function () {
                return view('dashboard');
            })->name('admin.dashboard');

            Route::get('/profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('admin.profile.update');
            Route::put('password', [ProfileController::class, 'updatePassword'])->name('admin.password.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('admin.profile.destroy');

            Route::controller(UserController::class)
                ->prefix('/users')
                ->group( function() {
                    Route::get('/add', 'create')
                        ->name('admin.users.create')
                        ->can('create user');
                    Route::get('/{user}', 'edit')
                        ->name('admin.users.edit')
                        ->can('update user');
                    Route::post('/', 'store')
                        ->name('admin.users.store')
                        ->can('create user');
                    Route::patch('/{user}', 'update')
                        ->name('admin.users.update')
                        ->can('update user');
                    Route::get('/', 'index')
                        ->name('admin.users.index')
                        ->can('view users');
                    Route::delete('/{user}', 'destroy')
                        ->name('admin.users.destroy')
                        ->can('delete user');
                });

            Route::get('/roles', RoleListController::class)->name('admin.roles.index');
        });

        Route::post('logout', [AdminLoginController::class, 'destroy'])
            ->name('admin.logout');
    });
});


