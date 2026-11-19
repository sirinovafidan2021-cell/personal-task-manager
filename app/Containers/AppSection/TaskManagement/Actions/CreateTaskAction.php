<?php

namespace App\Containers\AppSection\TaskManagement\Actions;

use App\Containers\AppSection\TaskManagement\Models\Task;
use App\Containers\AppSection\TaskManagement\Tasks\CreateTaskTask;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Actions\Action as ParentAction;

final class CreateTaskAction extends ParentAction
{
    public function __construct(private readonly CreateTaskTask $createTaskTask)
    {
    }

    public function run(User $user, array $attributes): Task
    {
        return $this->createTaskTask->run($user, $attributes);
    }
}
