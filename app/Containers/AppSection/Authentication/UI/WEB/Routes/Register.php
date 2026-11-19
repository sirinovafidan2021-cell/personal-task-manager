<?php

use App\Containers\AppSection\Authentication\UI\WEB\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest:web', 'throttle:5,1'])->group(static function (): void {
    Route::get('register', [RegisterController::class, 'showForm'])->name('register.form');
    Route::post('register', RegisterController::class)->name('register');
});
