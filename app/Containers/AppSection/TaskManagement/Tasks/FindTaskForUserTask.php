<?php

namespace App\Containers\AppSection\TaskManagement\Tasks;

use App\Containers\AppSection\TaskManagement\Models\Task;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Tasks\Task as ParentTask;

final class FindTaskForUserTask extends ParentTask
{
    public function run(User $user, int $taskId): Task
    {
        return $user->tasks()->findOrFail($taskId);
    }
}
