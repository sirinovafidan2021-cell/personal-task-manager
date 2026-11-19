<?php

use App\Containers\AppSection\Authentication\UI\WEB\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::post('login', LoginController::class)
    ->middleware(['guest:web', 'throttle:5,1'])
    ->name('login');

Route::get('login', [LoginController::class, 'showForm'])
    ->name('login.form')
    ->middleware(['guest:web']);
