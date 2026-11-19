<?php

namespace App\Containers\AppSection\TaskManagement\Tests\Functional\API;

use App\Containers\AppSection\TaskManagement\Models\Task;
use App\Containers\AppSection\TaskManagement\Tests\FunctionalTestCase;
use App\Containers\AppSection\TaskManagement\UI\API\Controllers\DeleteTaskController;
use App\Containers\AppSection\TaskManagement\UI\API\Controllers\FindTaskController;
use App\Containers\AppSection\TaskManagement\UI\API\Controllers\ListTasksController;
use App\Containers\AppSection\TaskManagement\UI\API\Controllers\UpdateTaskController;
use App\Containers\AppSection\User\Models\User;

final class TaskApiTest extends FunctionalTestCase
{
    public function testGuestCannotAccessTasks(): void
    {
        $this->getJson(action(ListTasksController::class))->assertUnauthorized();
    }

    public function testUserCanManageOnlyOwnTasks(): void
    {
        $owner = User::factory()->createOne();
        $other = User::factory()->createOne();
        $otherTask = Task::factory()->for($other)->createOne();
        $this->actingAs($owner, 'api');
        $tasksUrl = action(ListTasksController::class);
        $findUrl = fn (string $id): string => action(FindTaskController::class, ['task_id' => $id]);
        $updateUrl = fn (string $id): string => action(UpdateTaskController::class, ['task_id' => $id]);
        $deleteUrl = fn (string $id): string => action(DeleteTaskController::class, ['task_id' => $id]);

        $create = $this->postJson($tasksUrl, [
            'title' => 'Öz tapşırığım',
            'description' => 'Yalnız sahibinə görünür.',
            'is_completed' => false,
            'user_id' => $other->getKey(),
        ]);
        $create->assertUnprocessable()->assertJsonValidationErrors('user_id');

        $created = $this->postJson($tasksUrl, ['title' => 'Öz tapşırığım'])->assertCreated();
        $taskId = $created->json('data.id');
        $this->assertDatabaseHas('tasks', ['user_id' => $owner->getKey(), 'title' => 'Öz tapşırığım']);
        $this->getJson($tasksUrl . '?filter=pending')->assertOk()->assertJsonCount(1, 'data');
        $this->getJson($tasksUrl . '?filter=unknown')->assertUnprocessable();
        $this->getJson($findUrl($otherTask->getHashedKey()))->assertNotFound();
        $this->getJson($findUrl('not-a-valid-task-id'))->assertNotFound();
        $this->patchJson($updateUrl($otherTask->getHashedKey()), ['title' => 'Oğurlanmış'])->assertNotFound();
        $this->deleteJson($deleteUrl($otherTask->getHashedKey()))->assertNotFound();
        $this->patchJson($updateUrl($taskId), [])->assertUnprocessable();
        $this->patchJson($updateUrl($taskId), ['is_completed' => true])->assertOk()->assertJsonPath('data.is_completed', true);
        $this->getJson($tasksUrl . '?filter=completed')->assertOk()->assertJsonCount(1, 'data');
        $this->deleteJson($deleteUrl($taskId))->assertNoContent();
    }
}
