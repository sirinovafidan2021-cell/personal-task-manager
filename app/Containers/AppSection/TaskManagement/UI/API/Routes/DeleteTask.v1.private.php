<?php

use App\Containers\AppSection\TaskManagement\UI\API\Controllers\DeleteTaskController;
use Illuminate\Support\Facades\Route;

Route::delete('tasks/{task_id}', DeleteTaskController::class)->middleware(['auth:api']);
