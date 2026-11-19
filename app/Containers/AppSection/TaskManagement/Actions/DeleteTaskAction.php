<?php

namespace App\Containers\AppSection\TaskManagement\Actions;

use App\Containers\AppSection\TaskManagement\Tasks\DeleteTaskTask;
use App\Containers\AppSection\TaskManagement\Tasks\FindTaskForUserTask;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Actions\Action as ParentAction;

final class DeleteTaskAction extends ParentAction
{
    public function __construct(
        private readonly FindTaskForUserTask $findTaskForUserTask,
        private readonly DeleteTaskTask $deleteTaskTask,
    ) {
    }

    public function run(User $user, int $taskId): void
    {
        $this->deleteTaskTask->run($this->findTaskForUserTask->run($user, $taskId));
    }
}
