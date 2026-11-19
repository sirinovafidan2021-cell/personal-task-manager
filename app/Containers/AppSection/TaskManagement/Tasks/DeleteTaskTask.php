<?php

namespace App\Containers\AppSection\TaskManagement\Tasks;

use App\Containers\AppSection\TaskManagement\Models\Task;
use App\Ship\Parents\Tasks\Task as ParentTask;

final class DeleteTaskTask extends ParentTask
{
    public function run(Task $task): void
    {
        $task->delete();
    }
}
