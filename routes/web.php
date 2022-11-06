<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\LinkDeviceController;
use App\Http\Controllers\ReceiverController;
use App\Http\Controllers\SenderController;
use App\Http\Controllers\SendMessageController;
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

    Route::group(['prefix' => 'senders', 'as' => 'senders.'], function () {
        Route::group(['prefix' => '{sender}'], function () {
            Route::get('link-device', LinkDeviceController::class)->name('link-device');

            Route::get('groups', [GroupController::class, 'index'])->name('groups');

            Route::group(['prefix' => 'receivers', 'as' => 'receivers.'], function () {
                Route::group(['prefix' => '{receiver}'], function () {
                    Route::group(['prefix' => 'send-message', 'as' => 'send-message.'], function () {
                        Route::get('/', [SendMessageController::class, 'index'])->name('index');

                        Route::post('/', [SendMessageController::class, 'store'])->name('store');
                    });
                });
            });
        });
    });

    Route::resource('senders.receivers', ReceiverController::class)->except('index');

    Route::resource('senders', SenderController::class)->except([
        'edit',
        'update',
    ]);
});
