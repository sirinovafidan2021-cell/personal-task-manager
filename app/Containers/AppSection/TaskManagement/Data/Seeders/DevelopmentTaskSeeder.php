<?php

namespace App\Containers\AppSection\TaskManagement\Data\Seeders;

use App\Containers\AppSection\TaskManagement\Models\Task;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Seeders\Seeder as ParentSeeder;
use Illuminate\Support\Facades\Hash;

final class DevelopmentTaskSeeder extends ParentSeeder
{
    public function run(): void
    {
        if (app()->environment('production')) {
            return;
        }

        $sampleTasks = [
            'user1@example.com' => [
                ['title' => 'Həftəlik planı hazırla', 'description' => 'Prioritetləri müəyyən et.', 'is_completed' => false],
                ['title' => 'Laravel sənədlərini oxu', 'description' => 'Passport bölməsini nəzərdən keçir.', 'is_completed' => true],
                ['title' => 'Günün tapşırıqlarını tamamla', 'description' => null, 'is_completed' => false],
            ],
            'user2@example.com' => [
                ['title' => 'Görüş qeydlərini yaz', 'description' => 'Əsas qərarları qeyd et.', 'is_completed' => false],
                ['title' => 'Testləri işə sal', 'description' => 'Feature test nəticələrini yoxla.', 'is_completed' => true],
                ['title' => 'Sabah üçün hazırlıq et', 'description' => null, 'is_completed' => false],
            ],
        ];

        foreach ($sampleTasks as $email => $tasks) {
            $user = User::query()->firstOrCreate(
                ['email' => $email],
                ['name' => str($email)->before('@')->ucfirst()->toString(), 'password' => Hash::make('password')],
            );

            foreach ($tasks as $task) {
                Task::query()->firstOrCreate(['user_id' => $user->getKey(), 'title' => $task['title']], $task);
            }
        }
    }
}
