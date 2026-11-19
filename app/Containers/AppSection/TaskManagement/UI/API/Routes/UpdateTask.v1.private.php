<?php

use App\Containers\AppSection\TaskManagement\UI\API\Controllers\UpdateTaskController;
use Illuminate\Support\Facades\Route;

Route::patch('tasks/{task_id}', UpdateTaskController::class)->middleware(['auth:api']);
