<?php

namespace App\Containers\AppSection\TaskManagement\Tests\Functional\WEB;

use App\Containers\AppSection\TaskManagement\Tests\FunctionalTestCase;
use App\Containers\AppSection\TaskManagement\UI\WEB\Controllers\TasksPageController;
use App\Containers\AppSection\User\Models\User;

final class TaskWebConfigurationTest extends FunctionalTestCase
{
    public function testTaskPageUsesConfiguredApiOriginAndPreciseCorsOrigin(): void
    {
        $user = User::factory()->createOne();
        $this->actingAs($user, 'web')->withSession(['task_manager.access_token' => 'test-access-token']);

        $this->get(action(TasksPageController::class))
            ->assertOk()
            ->assertSee('127.0.0.1:8000', false)
            ->assertSee(route('tasks.index'), false)
            ->assertSee('__TASK_ID__', false);

        $this->assertSame([config('apiato.apps.web.url')], config('cors.allowed_origins'));
    }
}
