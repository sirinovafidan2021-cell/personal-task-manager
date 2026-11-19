<?php

namespace App\Containers\AppSection\TaskManagement\Actions;

use App\Containers\AppSection\TaskManagement\Models\Task;
use App\Containers\AppSection\TaskManagement\Tasks\FindTaskForUserTask;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Actions\Action as ParentAction;

final class FindTaskAction extends ParentAction
{
    public function __construct(private readonly FindTaskForUserTask $findTaskForUserTask)
    {
    }

    public function run(User $user, int $taskId): Task
    {
        return $this->findTaskForUserTask->run($user, $taskId);
    }
}
