<?php

namespace App\Containers\AppSection\TaskManagement\Tasks;

use App\Containers\AppSection\TaskManagement\Models\Task;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Illuminate\Database\Eloquent\Collection;

final class ListTasksTask extends ParentTask
{
    /** @return Collection<int, Task> */
    public function run(User $user, string $filter): Collection
    {
        return $user->tasks()
            ->when($filter === 'completed', fn ($query) => $query->where('is_completed', true))
            ->when($filter === 'pending', fn ($query) => $query->where('is_completed', false))
            ->latest()
            ->get();
    }
}
