<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GetAuthUserController;

Route::middleware(['auth:api'])->group(function () {
    Route::get('user', GetAuthUserController::class);
});

require __DIR__ . '/auth.php';