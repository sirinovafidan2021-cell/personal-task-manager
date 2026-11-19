<?php

namespace App\Containers\AppSection\TaskManagement\Tasks;

use App\Containers\AppSection\TaskManagement\Models\Task;
use App\Ship\Parents\Tasks\Task as ParentTask;

final class UpdateTaskTask extends ParentTask
{
    public function run(Task $task, array $attributes): Task
    {
        $task->fill($attributes);
        $task->save();

        return $task->refresh();
    }
}
