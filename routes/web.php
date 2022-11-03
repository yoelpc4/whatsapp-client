<?php

use App\Http\Controllers\ReceiverController;
use App\Http\Controllers\SenderController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', fn() => redirect('/login'));

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('dashboard', fn() => Inertia::render('Dashboard'))->name('dashboard');

    Route::resource('receivers', ReceiverController::class);

    Route::group(['prefix' => 'senders', 'as' => 'senders.'], function () {
        Route::get('{sender}/link-device', [SenderController::class, 'linkDevice'])->name('link_device');
    });
    Route::resource('senders', SenderController::class);
});
