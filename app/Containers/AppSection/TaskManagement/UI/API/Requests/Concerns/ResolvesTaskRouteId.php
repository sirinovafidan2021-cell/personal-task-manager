<?php

namespace App\Containers\AppSection\TaskManagement\UI\API\Requests\Concerns;

use App\Containers\AppSection\TaskManagement\Models\Task;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait ResolvesTaskRouteId
{
    protected function taskRouteId(): int|string
    {
        $taskId = last(explode('/', $this->path()));
        if (!config('apiato.hash-id')) {
            return $taskId;
        }

        $decoded = hashids()->decode($taskId);
        if (!is_int($decoded)) {
            throw (new ModelNotFoundException())->setModel(Task::class);
        }

        return $decoded;
    }
}
