<?php

namespace App\Containers\AppSection\TaskManagement\UI\API\Transformers;

use App\Containers\AppSection\TaskManagement\Models\Task;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

final class TaskTransformer extends ParentTransformer
{
    public function transform(Task $task): array
    {
        return [
            'type' => $task->getResourceKey(),
            'id' => $task->getHashedKey(),
            'title' => $task->title,
            'description' => $task->description,
            'is_completed' => $task->is_completed,
            'created_at' => $task->created_at?->toISOString(),
            'updated_at' => $task->updated_at?->toISOString(),
        ];
    }
}
