<?php

use Illuminate\Support\Facades\Route;
use \Illuminate\Http\Request;

Route::prefix('v1')->group(function () {
    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index']);
});
