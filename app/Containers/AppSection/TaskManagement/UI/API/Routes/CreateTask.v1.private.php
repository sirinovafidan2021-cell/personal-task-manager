<?php

use App\Containers\AppSection\TaskManagement\UI\API\Controllers\CreateTaskController;
use Illuminate\Support\Facades\Route;

Route::post('tasks', CreateTaskController::class)->middleware(['auth:api']);
