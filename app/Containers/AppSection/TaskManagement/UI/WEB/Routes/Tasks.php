<?php

use App\Containers\AppSection\TaskManagement\UI\WEB\Controllers\TaskFormPageController;
use App\Containers\AppSection\TaskManagement\UI\WEB\Controllers\TasksPageController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:web'])->group(static function (): void {
    Route::get('tasks', TasksPageController::class)->name('tasks.index');
    Route::get('tasks/create', [TaskFormPageController::class, 'create'])->name('tasks.create');
    Route::get('tasks/{task_id}/edit', [TaskFormPageController::class, 'edit'])->name('tasks.edit');
});
