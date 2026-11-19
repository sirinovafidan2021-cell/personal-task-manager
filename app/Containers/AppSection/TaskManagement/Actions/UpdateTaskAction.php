<?php

namespace App\Containers\AppSection\TaskManagement\Actions;

use App\Containers\AppSection\TaskManagement\Models\Task;
use App\Containers\AppSection\TaskManagement\Tasks\FindTaskForUserTask;
use App\Containers\AppSection\TaskManagement\Tasks\UpdateTaskTask;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Actions\Action as ParentAction;

final class UpdateTaskAction extends ParentAction
{
    public function __construct(
        private readonly FindTaskForUserTask $findTaskForUserTask,
        private readonly UpdateTaskTask $updateTaskTask,
    ) {
    }

    public function run(User $user, int $taskId, array $attributes): Task
    {
        return $this->updateTaskTask->run(
            $this->findTaskForUserTask->run($user, $taskId),
            $attributes,
        );
    }
}
