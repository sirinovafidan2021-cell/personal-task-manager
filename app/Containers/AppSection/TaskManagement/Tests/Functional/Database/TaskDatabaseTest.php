<?php

namespace App\Containers\AppSection\TaskManagement\Tests\Functional\Database;

use App\Containers\AppSection\TaskManagement\Data\Seeders\DevelopmentTaskSeeder;
use App\Containers\AppSection\TaskManagement\Models\Task;
use App\Containers\AppSection\TaskManagement\Tests\FunctionalTestCase;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

final class TaskDatabaseTest extends FunctionalTestCase
{
    public function testTaskSchemaRelationshipAndDefaultAreCorrect(): void
    {
        $this->assertTrue(Schema::hasColumns('tasks', ['id', 'user_id', 'title', 'description', 'is_completed', 'created_at', 'updated_at']));

        $user = User::factory()->createOne();
        $task = $user->tasks()->create(['title' => 'Əlaqə testi']);
        $this->assertFalse($task->refresh()->is_completed);
        $this->assertTrue($task->user->is($user));
        $this->assertTrue($user->tasks->contains($task));

        if (DB::getDriverName() === 'sqlite') {
            $indexNames = array_column(DB::select("pragma index_list('tasks')"), 'name');
            $foreignKeys = DB::select("pragma foreign_key_list('tasks')");
            $this->assertContains('tasks_user_id_index', $indexNames);
            $this->assertContains('tasks_user_id_is_completed_index', $indexNames);
            $this->assertSame('CASCADE', $foreignKeys[0]->on_delete);
            $userColumns = collect(DB::select("pragma table_info('users')"))->keyBy('name');
            $this->assertSame(1, $userColumns['name']->notnull);
            $this->assertSame(1, $userColumns['email']->notnull);
            $this->assertSame(1, $userColumns['password']->notnull);
        }
    }

    public function testDevelopmentSeederIsIdempotentAndCreatesSixTasks(): void
    {
        $this->seed(DevelopmentTaskSeeder::class);
        $this->seed(DevelopmentTaskSeeder::class);

        $this->assertDatabaseHas('users', ['email' => 'user1@example.com']);
        $this->assertDatabaseHas('users', ['email' => 'user2@example.com']);
        $this->assertCount(3, User::query()->where('email', 'user1@example.com')->firstOrFail()->tasks);
        $this->assertCount(3, User::query()->where('email', 'user2@example.com')->firstOrFail()->tasks);
    }
}
