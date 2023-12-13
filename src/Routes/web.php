<?php

use Bagisto\GoogleAuth\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

$middleware = ['web'];
$prefix = config('app.admin_url') . '/google';

Route::group(['middleware' => $middleware, 'prefix' => $prefix], function () {
    Route::get('/auth', [SessionController::class, 'redirectToGoogle'])->name('google.authenticate');

    Route::get('/callback', [SessionController::class, 'handleCallback'])->name('google.callback');
});
