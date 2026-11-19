<?php

namespace App\Containers\AppSection\TaskManagement\Data\Repositories;

use App\Containers\AppSection\TaskManagement\Models\Task;
use App\Ship\Parents\Repositories\Repository as ParentRepository;

/**
 * @extends ParentRepository<Task>
 */
final class TaskRepository extends ParentRepository
{
    public function model(): string
    {
        return Task::class;
    }
}
