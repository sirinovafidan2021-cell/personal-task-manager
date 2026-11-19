<?php

use App\Containers\AppSection\TaskManagement\UI\API\Controllers\ListTasksController;
use Illuminate\Support\Facades\Route;

Route::get('tasks', ListTasksController::class)->middleware(['auth:api']);
