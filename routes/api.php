<?php

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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->get('/billing-portal', function (Request $request) {
    //$request->user()->createOrGetStripeCustomer();
    return $request->user()->billingPortalUrl();
});

Route::get('/', function () {
    return ['this-is-laravel-api' => app()->version()];
});

require __DIR__.'/auth.php';
