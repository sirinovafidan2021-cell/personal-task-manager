<?php

use App\Containers\AppSection\TaskManagement\UI\API\Controllers\FindTaskController;
use Illuminate\Support\Facades\Route;

Route::get('tasks/{task_id}', FindTaskController::class)->middleware(['auth:api']);
