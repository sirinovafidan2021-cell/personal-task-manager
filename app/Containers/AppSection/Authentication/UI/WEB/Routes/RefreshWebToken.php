<?php

use App\Containers\AppSection\Authentication\UI\WEB\Controllers\RefreshWebTokenController;
use Illuminate\Support\Facades\Route;

Route::post('tasks/token/refresh', RefreshWebTokenController::class)
    ->middleware(['auth:web', 'throttle:30,1'])
    ->name('tasks.token.refresh');
