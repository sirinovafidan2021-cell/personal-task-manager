<?php

namespace App\Containers\AppSection\TaskManagement\Data\Factories;

use App\Containers\AppSection\TaskManagement\Models\Task;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Factories\Factory as ParentFactory;

/**
 * @extends ParentFactory<Task>
 */
final class TaskFactory extends ParentFactory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->optional()->paragraph(),
            'is_completed' => fake()->boolean(),
        ];
    }

    public function completed(): self
    {
        return $this->state(fn (): array => ['is_completed' => true]);
    }
}
