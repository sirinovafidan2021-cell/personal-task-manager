<?php

namespace App\Containers\AppSection\TaskManagement\Actions;

use App\Containers\AppSection\TaskManagement\Tasks\ListTasksTask;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Actions\Action as ParentAction;
use Illuminate\Database\Eloquent\Collection;

final class ListTasksAction extends ParentAction
{
    public function __construct(private readonly ListTasksTask $listTasksTask)
    {
    }

    public function run(User $user, string $filter = 'all'): Collection
    {
        return $this->listTasksTask->run($user, $filter);
    }
}
